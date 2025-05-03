<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Tes;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function beranda()
    {  
        Carbon::setLocale('id');

        $layanan = Auth::user()->layanan()->with([
            'pengguna' => function($query) {
                $query->where('role', 'pendaftar');
            },
            'topik',
            'narasumber'
        ])->first();

        $pendaftar = $layanan ? $layanan->pengguna->first() : null;
        $pengguna = Auth::user();

        $tes = null;
        if ($layanan) {
            $pivot = $layanan->pengguna()->where('pengguna_id', $pengguna->id)->first();
            
            if ($pivot && $pivot->pivot->tes_id) {
                $tes = \App\Models\Tes::find($pivot->pivot->tes_id);
            }
        }
        
        $topikPertama = $layanan && $layanan->topik ? $layanan->topik->first() : null;

        $hariKegiatan = Carbon::now()->diffInDays(Carbon::parse($layanan->tanggal), false);
        $hariNonaktif = Carbon::now()->diffInDays(Carbon::parse($pengguna->expired_at), false);

        
        return view('peserta.beranda', compact(
            'layanan', 'pengguna', 'pendaftar',
            'hariKegiatan', 'hariNonaktif',
            'topikPertama', 'tes'
        ));
    }

}
