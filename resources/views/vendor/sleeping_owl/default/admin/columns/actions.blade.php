@php
    $editUrl    = route('admin.posts.edit', ['type' => class_basename($model), 'id' => $model->id]);
    $deleteUrl  = route('admin.posts.destroy', ['id' => $model->id, 'type' => class_basename($model)]);
    $csrf       = csrf_token();
    $modelClass = class_basename($model);
@endphp

<a href="{{ $editUrl }}" class="btn btn-sm btn-primary">✏️</a>

<form method="POST" action="{{ $deleteUrl }}" class="delete-form" style="display:inline;">
    @csrf
    <input type="hidden" name="delete" value="DELETE">
    <input type="hidden" name="type" value="{{ $modelClass }}">
    <button type="button" class="btn btn-sm btn-danger btn-delete">🗑</button>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const form = btn.closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
