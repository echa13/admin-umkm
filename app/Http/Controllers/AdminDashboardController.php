<?php
namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            // Jika user belum login, redirect ke halaman login
            return redirect()->route('login')->with('error','Silakan login!');
        }

        // Jika sudah login, tampilkan dashboard
        return view('pages.index', [
            'totalWarga'  => Warga::count(),
            'totalUser'   => User::count(),
            'totalUmkm'   => Umkm::count(),
            'latestWarga' => Warga::orderBy('warga_id', 'desc')->take(5)->get(),
            'latestUmkm'  => Umkm::orderBy('umkm_id', 'desc')->take(5)->get(),
            'chartLabels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            'chartData'   => [4, 6, 9, 5, 12],
            'activities'  => [],
        ]);
    }

}
