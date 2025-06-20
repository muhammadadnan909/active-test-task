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
    public function index()
    {
        $searchTerm = request()->get('query', ''); // search param
        $page       = request()->get('page', 1);       // ✅ correct way
        $perPage    = 25;                       // results per page
        $from       = ($page - 1) * $perPage;    //offset

        if($searchTerm)
        {
            $mustQuery = Query::term()
              ->field('title.keyword')
              ->value($searchTerm); // must be exactly the full title string


            $boolQuery = Query::bool()->must($mustQuery);

            if (Auth::guard('user')->check()) {
                $boolQuery->filter(
                    Query::term()->field('user_id')->value($this->userId)
                );
            }



            $postResponse = Post::searchQuery($boolQuery)
                ->source(['id'])
                ->from($from)
                ->size($perPage)
                ->sort('id', 'desc')
                ->execute();

            $posts = $postResponse->models();
            $postTotal = $postResponse->total();

            // Search Folders
            $folderResponse = Folder::searchQuery($boolQuery)
                ->source(['id'])
                ->from($from)
                ->size($perPage)
                ->sort('id', 'desc')
                ->execute();

            $folders = $folderResponse->models();
            $folderTotal = $folderResponse->total();

            // Add model type manually for rendering
            $posts->each->setAttribute('type', 'Post');
            $folders->each->setAttribute('type', 'Folder');

            // Combine and sort
            $combined = $posts->concat($folders)->sortByDesc('id')->values();

            // Total results (not just combined page)
            $total = $postTotal + $folderTotal;

            // Paginate manually (note: Elasticsearch pagination per-model; this is approximate)
            $paginatedItems = $combined->slice(0, $perPage)->values();


        }else{

            if (Auth::guard('user')->check()) {
                $postsQuery = Post::query();
                $foldersQuery = Folder::query();
            } else {
                $postsQuery = Post::query()->where('user_id', Auth::id());
                $foldersQuery = Folder::query()->where('user_id', Auth::id());
            }
            $posts = $postsQuery->get();
            $folders = $foldersQuery->get();
            // Add type indicator if needed
            $posts->each->setAttribute('type', 'post');
            $folders->each->setAttribute('type', 'folder');

            // Merge, sort, and paginate
            $concat = $posts->concat($folders)->sortByDesc('id')->values();

            $total = $concat->count();
            $paginatedItems = $concat->slice($from, $perPage)->values();
        }

        $paginated = new LengthAwarePaginator(
            $paginatedItems,
            $total,
            $perPage,
            $page,
              [
                    'path'  => url()->current(), // This ensures pagination stays on /search
                    'query' => request()->query(), // Preserves existing query params like ?query=test
            ]
        );


        $data['posts'] = $paginated;
        $data ['guard'] = $this->role;

        return view('posts.index', $data);
    }

    public function destroy($type, $id)
    {
        if($type == 'post')
            $record = Post::findOrFail($id);
        else if($type == 'folder')
            $record = Folder::findOrFail($id);

        $record->delete();
        return redirect()->back()->with('success',  ucfirst($type) .' deleted successfully.');
    }


    public function edit($type, $id)
    {
        if($type == 'post')
            $record = Post::findOrFail($id);
        else if($type == 'folder')
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

        if($type == 'post')
            $record = Post::findOrFail($id);
        else if($type == 'folder')
            $record = Folder::findOrFail($id);

        $record->title   = $request->input('title');
        $record->content = $request->input('content');
        $record->role    = $this->role;
        $record->save();

        return redirect()->route($this->role.'.home')->with('success', ucfirst($type).' updated successfully.');
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
