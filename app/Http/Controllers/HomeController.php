<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Peminjaman;
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

            $totalBuku = Buku::sum('stok');
            $dipinjam = Peminjaman::where('status', 'dipinjam')->count();
            $terlambat = Peminjaman::where('status', 'dipinjam')
                ->whereDate('tanggal_kembali', '<', now()->toDateString())
                ->count();
            $terlambat += Peminjaman::where('status', 'terlambat')->count();
            $users = User::where('usertype', 'user')->count();
            $totalTransaksi = Peminjaman::count();
            $totalDenda = Peminjaman::where('denda', '>', 0)->sum('denda');

            $grafikDenda = [];

            for ($bulan = 1; $bulan <= 12; $bulan++) {

                $grafikDenda[] = Peminjaman::whereYear(
                    'created_at',
                    now()->year
                )
                    ->whereMonth('created_at', $bulan)
                    ->sum('denda');
            }

            $statusTransaksi = [
                Peminjaman::where('status', 'dipinjam')->count(),
                Peminjaman::where('status', 'terlambat')->count(),
                Peminjaman::where('status', 'kembali')->count(),
            ];

            $title = 'Admin Dashboard';

            $widget = [
                'total_buku' => $totalBuku,
                'dipinjam' => $dipinjam,
                'terlambat' => $terlambat,
                'users' => $users,
                'total_transaksi' => $totalTransaksi,
                'total_denda' => $totalDenda,
                'grafik_denda' => $grafikDenda,
                'status_transaksi' => $statusTransaksi,
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
        $selectedRole = $request->query('role');
        $query = User::query();

        if ($selectedRole && $selectedRole !== 'all') {
            $query->where('usertype', $selectedRole);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%");
            });
        }

        $data = $query->orderBy('name', 'asc')->get();
        $title = 'All Users';

        return view('admin.users.index', compact('data', 'title', 'selectedRole'));
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
            'password' => 'required|string|min:8|confirmed',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:1048',
            'usertype' => 'required|in:user,admin',
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
            'password' => Hash::make($request->password),
            'foto_profile' => $filename,
            'usertype' => $request->usertype,
            'user_code' => $request->usertype === 'user'
                ? User::generateUserCode()
                : null,
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
            'password' => 'nullable|string|min:8|confirmed',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:1048',
            'usertype' => 'required|in:user,admin',
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

    public function kartu_user()
    {
        $user = User::where('usertype', 'user')
            ->orderBy('name', 'asc')
            ->get();

        $title = 'Kartu Anggota';

        return view('admin.users.kartu.kartu', compact('user', 'title'));
    }

    public function detail_kartu_user(string $id)
    {
        $user = User::where('usertype', 'user')
            ->findOrFail($id);

        $title = 'Detail Kartu Anggota';

        return view(
            'admin.users.kartu.detail-kartu',
            compact('user', 'title')
        );
    }
}
