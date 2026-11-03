<?php

namespace App\Http\Controllers\Keluarga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user('web');

        $lansiaList = $user->lansia()->withPivot('is_primary')->get();

        return view('keluarga.dashboard', [
            'user' => $user,
            'lansiaList' => $lansiaList,
        ]);
    }
}
