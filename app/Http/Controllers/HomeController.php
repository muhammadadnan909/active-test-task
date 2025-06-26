<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Folder;
use ElasticScoutDriverPlus\Support\Query;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;
use ElasticScoutDriverPlus\Builders\SearchRequestBuilder;
use ElasticAdapter\Search\Bucket;
use App\Services\SearchService;
use App\Services\PaginationService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $userId;
    private $role;

    public function __construct()
    {
        $this->middleware('auth');

        if(Auth::guard('user')->check()){
            $this->userId = Auth::guard('user')->id();
            $this->role = 'user';
        }else{
            $this->userId = Auth::guard('admin')->id();
            $this->role = 'admin';
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(SearchService $searchService, PaginationService $paginationService)
    {

        $searchTerm = request()->get('query', ''); // search param
        $page       = request()->get('page', 1);       // ✅ correct way
        $perPage    = 25;                       // results per page
        $from       = ($page - 1) * $perPage;    //offset


        $searchTerm = request()->get('query', '');
        $page = (int) request()->get('page', 1);
        $perPage = 25;

        ['combined' => $items, 'total' => $total] = $searchService->search($searchTerm, $page, perPage: $perPage);

        $paginated = $paginationService->paginate(collect($items), $total, $perPage, $page);

        $data['posts'] = $paginated;
        $data ['guard'] = $this->role;

        return view('posts.index', $data);
    }

    public function destroy(Request $request, $id, $type)
    {
        if($request->type == 'Post')
            $record = Post::findOrFail($id);
        else if($request->type  == 'Folder')
            $record = Folder::findOrFail($id);

        $record->delete();
        return redirect("/admin/posts")->with('success', ucfirst($type) . ' deleted successfully.');

    }


    public function edit($type, $id)
    {
        if($type == 'Post')
            $record = Post::findOrFail($id);
        else if($type == 'Folder')
            $record = Folder::findOrFail($id);

            $guard = $this->role;

        return view('posts.edit', compact('record', 'type', 'guard'));
    }

    // Update the post
    public function update(Request $request, $type ,$id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if($type == 'Post')
            $record = Post::findOrFail($id);
        else if($type == 'Folder')
            $record = Folder::findOrFail($id);

        $record->title   = $request->input('title');
        $record->content = $request->input('content');
        $record->role    = $this->role;
        $record->save();

        return redirect('/admin/posts')->with('success', ucfirst($type).' updated successfully.');

    }

    public function create($type)
    {
        $guard = $this->role;
        return view('posts.create', compact('type', 'guard'));
    }


    // Handle form submission
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $type   =  $request->type;


        if(Auth::guard('user')->check()){
            $userId = Auth::guard('user')->id();
        }else{
            $userId = Auth::guard('admin')->id();
        }


        if($type == 'post')
            $record = new Post();
        else if($type == 'folder')
            $record = new Folder();

        $record->title   = $request->input('title');
        $record->content = $request->input('content');
        $record->user_id = $this->userId; // Optional if using auth
        $record->role    = $this->role;
        $record->save();

        return redirect()->route($this->role.'.home')->with('success', ucfirst($type) .' created successfully.');
    }
}
