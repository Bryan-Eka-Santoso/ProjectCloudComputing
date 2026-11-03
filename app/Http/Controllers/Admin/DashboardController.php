<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Lansia;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalKeluarga' => User::where('role', 'keluarga')->count(),
            'totalLansia' => Lansia::count(),
            'totalGame' => Game::count(),
        ]);
    }
}
