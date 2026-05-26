<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active', 'role:super_admin']);
    }

    public function index(Request $request)
    {
        $role = $request->get('role', User::ROLE_STUDENT);

        $users = User::where('role', $role)
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($inner) use ($request) {
                    $inner->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                        ->orWhere('student_id', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users', 'role'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in([User::ROLE_STUDENT, User::ROLE_OFFICER, User::ROLE_SUPER_ADMIN])],
            'student_id' => ['nullable', 'string', 'max:50', 'unique:users'],
            'course' => ['nullable', 'string'],
            'year_level' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
        ]);

        User::create(array_merge($validated, [
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
            'is_active' => true,
        ]));

        return redirect()->route('admin.users.index', ['role' => $validated['role']])
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in([User::ROLE_STUDENT, User::ROLE_OFFICER, User::ROLE_SUPER_ADMIN])],
            'student_id' => ['nullable', 'string', Rule::unique('users')->ignore($user->id)],
            'course' => ['nullable', 'string'],
            'year_level' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_active' => ['boolean'],
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->boolean('is_active');

        $user->update($validated);

        return back()->with('success', 'User updated successfully.');
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', 'Account status updated.');
    }
}
