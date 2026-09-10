<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {

            $user_type = Auth::user()->usertype;

            if ($user_type == 'admin') {
                $users = User::all()->count();
                $kategori = Kategori::all()->count();

                $title = 'Admin Dashboard';

                $widget = [
                    'users' => $users,
                ];

                return view('admin.home', compact('widget', 'title'));
            }

            if ($user_type == 'user') {
                $data = [];
                $title = 'Home';

                return view('user.index', compact('data', 'title'));
            }

            return redirect()->back();
        }

        return redirect()->route('login');
    }

    public function show_user(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $data = User::where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%")
                ->get();
        } else {
            $data = User::all();
        }

        $title = 'All Users';

        return view('admin.users.index', compact('data', 'title'));
    }

    public function create_user()
    {
        return view('admin.users.create');
    }

    public function store_user(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:1,15',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'usertype' => 'required|in:user,admin',
            'password' => 'required|string|min:8|confirmed',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:1048',
        ]);

        $filename = null;

        if ($request->hasFile('foto_profile')) {

            $file = $request->file('foto_profile');

            $filename = time() . '_' . uniqid() . '.' .
                $file->getClientOriginalExtension();

            $file->move(
                public_path('uploads/profile'),
                $filename
            );
        }

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'usertype' => $request->usertype,
            'password' => Hash::make($request->password),
            'foto_profile' => $filename,
        ]);

        return redirect()
            ->route('admin.users')
            ->with('success', 'Data user berhasil ditambahkan!');
    }

    public function edit_user(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update_user(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:1,15',
            'address' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'usertype' => 'required|in:user,admin',
            'password' => 'nullable|string|min:8|confirmed',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:1048',
        ]);

        $filename = $user->foto_profile;

        if ($request->hasFile('foto_profile')) {

            if (
                $user->foto_profile &&
                file_exists(public_path('uploads/profile/' . $user->foto_profile))
            ) {
                unlink(public_path('uploads/profile/' . $user->foto_profile));
            }

            $file = $request->file('foto_profile');

            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->move(
                public_path('uploads/profile'),
                $filename
            );
        }

        $updateData = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'usertype' => $request->usertype,
            'foto_profile' => $filename,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()
            ->route('admin.users')
            ->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy_user(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->foto_profile && file_exists(public_path('uploads/profile/' . $user->foto_profile))) {
            unlink(public_path('uploads/profile/' . $user->foto_profile));
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Data user berhasil dihapus!');
    }
}
