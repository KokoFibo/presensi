<?php

use Carbon\Carbon;

function tgl_indo($date)
{
    return Carbon::parse($date)->locale('id')->translatedFormat('l, j F Y');
}
