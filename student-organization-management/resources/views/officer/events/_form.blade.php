<div class="card card-stat"><div class="card-body">
<form action="{{ $action }}" method="POST">@csrf @if(!empty($method)) @method($method) @endif
    <div class="mb-3"><label class="form-label">Title</label><input name="title" class="form-control" value="{{ old('title', $event->title ?? '') }}" required></div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description', $event->description ?? '') }}</textarea></div>
    <div class="mb-3"><label class="form-label">Location</label><input name="location" class="form-control" value="{{ old('location', $event->location ?? '') }}"></div>
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Starts At</label><input type="datetime-local" name="starts_at" class="form-control" value="{{ old('starts_at', isset($event) ? $event->starts_at->format('Y-m-d\TH:i') : '') }}" required></div>
        <div class="col-md-6"><label class="form-label">Ends At</label><input type="datetime-local" name="ends_at" class="form-control" value="{{ old('ends_at', isset($event->ends_at) ? $event->ends_at->format('Y-m-d\TH:i') : '') }}"></div>
    </div>
    <button class="btn btn-primary mt-3">Save</button>
</form>
</div></div>
