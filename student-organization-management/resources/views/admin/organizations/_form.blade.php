<div class="card card-stat"><div class="card-body">
<form method="POST" action="{{ $action }}">@csrf @if(!empty($method)) @method($method) @endif
    <div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ old('name', $organization->name ?? '') }}" required></div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description', $organization->description ?? '') }}</textarea></div>
    <div class="mb-3"><label class="form-label">Officer</label>
        <select name="officer_id" class="form-select">
            <option value="">— None —</option>
            @foreach($officers as $o)<option value="{{ $o->id }}" @selected(old('officer_id', $organization->officer_id ?? '') == $o->id)>{{ $o->name }}</option>@endforeach
        </select>
    </div>
    <div class="mb-3"><label class="form-label">Status</label>
        <select name="status" class="form-select">
            @foreach(['pending','approved','rejected'] as $s)<option value="{{ $s }}" @selected(old('status', $organization->status ?? 'pending') === $s)>{{ ucfirst($s) }}</option>@endforeach
        </select>
    </div>
    <button class="btn btn-primary">Save</button>
</form>
</div></div>
