@extends('layouts.app-admin')

@section('content')
<div class="container">
    <h2>Edit {{ ucfirst($type) }}</h2>

    <form id="update-form" method="POST" action="{{ route('posts.update', ['type' => $type, 'id' => $record->id]) }}">
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

        <button type="button" class="btn btn-primary" onclick="confirmUpdate()">Update</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@push('scripts')
{{-- Include SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmUpdate() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to update the record?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('update-form').submit();
            }
        });
    }
</script>
@endpush
