<?php

namespace App\Http\Controllers\Lansia;

use App\Http\Controllers\Controller;
use App\Models\GoalHarian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function toggle(Request $request, GoalHarian $goal): RedirectResponse
    {
        $lansia = $request->user('lansia');

        abort_unless($goal->lansia_id === $lansia->id, 403);

        $goal->update(['is_selesai' => ! $goal->is_selesai]);

        return redirect()->route('lansia.dashboard');
    }
}
