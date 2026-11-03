<?php

namespace App\Mail;

use App\Models\Lansia;
use App\Models\SosLog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SosTriggeredMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Lansia $lansia,
        public SosLog $log,
    ) {
    }

    public function build(): self
    {
        return $this->subject("SOS: {$this->lansia->nama} butuh bantuan")
            ->markdown('mail.sos-triggered', [
                'lansia' => $this->lansia,
                'log' => $this->log,
            ]);
    }
}
