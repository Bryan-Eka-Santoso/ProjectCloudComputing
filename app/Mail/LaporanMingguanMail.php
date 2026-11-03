<?php

namespace App\Mail;

use App\Models\Lansia;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class LaporanMingguanMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Lansia $lansia,
        public Collection $sesiMingguIni,
        public int $totalPoinGoal,
        public int $totalMenitMain,
    ) {
    }

    public function build(): self
    {
        return $this->subject("Laporan Mingguan Ceria Otak: {$this->lansia->nama}")
            ->markdown('mail.laporan-mingguan', [
                'lansia' => $this->lansia,
                'sesiMingguIni' => $this->sesiMingguIni,
                'totalPoinGoal' => $this->totalPoinGoal,
                'totalMenitMain' => $this->totalMenitMain,
            ]);
    }
}
