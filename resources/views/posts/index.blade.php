@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Search Posts / Folder Records</h2>
    <a href="{{ route($guard.'.posts.create', 'post') }}" class="btn btn-success mb-3">Add New Post</a>
    <a href="{{ route($guard.'.posts.create', 'folder') }}" class="btn btn-primary mb-3">Add New Folder</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search Form --}}
    <form method="GET" action="{{ url()->current() }}" class="mb-4">
        <div class="input-group">
            <input
                type="text"
                name="query"
                class="form-control"
                placeholder="Search title..."
                value="{{ request('query') }}"
            >
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    {{-- Results Table --}}
    <div class="row justify-content-center">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>User Role</th>
                    <th>Model</th>
                    <th>Update At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ Str::limit($post->content, 100) }}</td>
                        <td>{{ $post->role ? ucfirst($post->role) :  'Unknown' }}</td>
                        <td>{{ ucfirst($post->type) }}</td>
                        <td>{{ $post->updated_at->diffForHumans() }}</td>
                        <td>
                                <div style="display: flex; gap: 5px; align-items: center;">
                                    <a href="{{ route($guard.'.posts.edit',  ['type' => $post->type, 'id' => $post->id]) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route($guard.'.posts.destroy', ['type' => $post->type, 'id' => $post->id]) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No results found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $posts->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
