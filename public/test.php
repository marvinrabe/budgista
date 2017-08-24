<?php

include '../vendor/autoload.php';

use Symfony\Component\Intl\Intl;

foreach(Intl::getLocaleBundle()->getLocaleNames() as $key => $locale) {
    echo $key.'<br>';
}