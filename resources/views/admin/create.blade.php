@extends('layouts.app-admin')

@section('content')
<div class="container">
    <h2>Add New {{ ucfirst($type) }}</h2>

    <form method="POST" action="{{ route('posts.store') }}">
        @csrf

        <input type="hidden" name="type" value="{{ $type }}" />

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="5" required></textarea>
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
