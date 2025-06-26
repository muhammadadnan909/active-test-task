@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit {{ ucfirst($type) }}</h2>

    <form method="POST" action="{{ route($guard.'.posts.update', ['type' => $type, 'id' => $record->id]) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $record->title) }}" required>
        </div>

        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="5" required>{{ old('content', $record->content) }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="#" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
