<?php

function either($a, $b)
{
    return $a !== null ? $a : value($b);
}
