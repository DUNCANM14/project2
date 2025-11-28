<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment("Keep pushing!");
})->purpose('Display a motivational quote');
