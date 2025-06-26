<a href="{{ route('admin.model.edit', ['posts', $model->getKey()]) }}" class="btn btn-sm btn-info">✏️ Edit</a>
<form method="POST" action="{{ route('admin.model.delete', ['posts', $model->getKey()]) }}" style="display:inline;">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">🗑 Delete</button>
</form>
