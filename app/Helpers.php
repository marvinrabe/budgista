<?php

use Illuminate\Support\ViewErrorBag;

function session_error($key, $message)
{
    session()->flash(
        'errors', session()->get('errors', new ViewErrorBag)->put($key, $message)
    );
}
