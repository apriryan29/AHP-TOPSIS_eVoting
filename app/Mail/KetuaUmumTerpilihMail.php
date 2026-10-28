<?php

namespace App\Mail;

use App\Models\Kandidat;
use Illuminate\Mail\Mailable;

class KetuaUmumTerpilihMail extends Mailable
{
    public $kandidat;

    public function __construct(Kandidat $kandidat)
    {
        $this->kandidat = $kandidat;
    }

    public function build()
    {
        return $this
            ->subject('Hasil Pemilihan Ketua Umum')
            ->view('emails.ketua-umum');
    }
}
