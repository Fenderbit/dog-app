<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $d = \App\Models\Food_purchase::latest()->first()->toArray();
    dd($d);
})->purpose('Display an inspiring quote')->hourly();
