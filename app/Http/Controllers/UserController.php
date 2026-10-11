<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $search = request('search');
        $role = request('role');

        return view('users.index', [
            'users' => User::query()
                ->when($search, fn ($query) => $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%');
                }))
                ->when($role && in_array($role, config('user-management.roles'), true), fn ($query) => $query->where('role', $role))
                ->latest()
                ->paginate(10)
                ->withQueryString(),
            'roles' => config('user-management.roles'),
            'totalUsers' => User::query()->count(),
            'adminUsers' => User::query()->where('role', 'Admin')->count(),
            'memberUsers' => User::query()->where('role', 'Member')->count(),
            'search' => $search,
            'selectedRole' => $role,
        ]);
    }

    public function overview(): View
    {
        return view('admin.overview', [
            'totalUsers' => User::query()->count(),
            'adminUsers' => User::query()->where('role', 'Admin')->count(),
            'memberUsers' => User::query()->where('role', 'Member')->count(),
        ]);
    }

    public function weatherPage(): View
    {
        return view('admin.weather');
    }

    public function weather(Request $request, WeatherService $weatherService): JsonResponse
    {
        $validated = $request->validate([
            'location' => ['nullable', 'string', 'max:100'],
        ]);

        $weather = $weatherService->current($validated['location'] ?? null);

        if ($weather === null) {
            return response()->json([
                'message' => 'Weather information is unavailable for that location right now.',
            ], 422);
        }

        return response()->json($weather);
    }

    public function create(): View
    {
        return view('users.create', [
            'roles' => config('user-management.roles'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:'.implode(',', config('user-management.roles'))],
        ]);

        User::create($validated);

        return to_route('users.index')->with('status', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        return view('users.edit', [
            'user' => $user,
            'roles' => config('user-management.roles'),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:'.implode(',', config('user-management.roles'))],
        ]);

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $user->update($validated);

        return to_route('users.index')->with('status', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return to_route('users.index')->with('status', 'User deleted successfully.');
    }
}
