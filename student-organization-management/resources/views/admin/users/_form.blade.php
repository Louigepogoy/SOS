<div class="card card-stat"><div class="card-body">
<form method="POST" action="{{ $action }}">@csrf @if(!empty($method)) @method($method) @endif
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required></div>
        <div class="col-md-6"><label class="form-label">Email</label><input name="email" type="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required></div>
        <div class="col-md-6"><label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                @foreach(['student','officer','super_admin'] as $r)
                    <option value="{{ $r }}" @selected(old('role', $user->role ?? 'student') === $r)>{{ ucfirst(str_replace('_',' ',$r)) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6"><label class="form-label">Student ID</label><input name="student_id" class="form-control" value="{{ old('student_id', $user->student_id ?? '') }}"></div>
        <div class="col-md-6"><label class="form-label">Password {{ $user ? '(leave blank to keep)' : '' }}</label><input name="password" type="password" class="form-control" {{ $user ? '' : 'required' }}></div>
        <div class="col-md-6"><label class="form-label">Confirm Password</label><input name="password_confirmation" type="password" class="form-control"></div>
        @if($user)
        <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->is_active))><label class="form-check-label">Active Account</label></div></div>
        @endif
    </div>
    <button class="btn btn-primary mt-3">Save</button>
</form>
</div></div>
