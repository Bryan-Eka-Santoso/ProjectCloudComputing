<?php

namespace App\Http\Middleware;

use App\Models\Lansia;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPrimaryCaregiver
{
    /**
     * Batasi aksi sensitif (data kesehatan, pembayaran, hak akses) hanya
     * untuk keluarga yang berstatus primary caregiver dari lansia terkait.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user('web');
        $lansiaId = $request->route('lansia');

        $lansia = $lansiaId instanceof Lansia
            ? $lansiaId
            : Lansia::find($lansiaId);

        if (! $user || ! $lansia || ! $user->isPrimaryUntuk($lansia)) {
            abort(403, 'Hanya primary caregiver yang dapat melakukan aksi ini.');
        }

        return $next($request);
    }
}
