<?php

function currency_format($number, App\Models\Budget $budget)
{
    $formatter = new NumberFormatter(Locale::getDefault(), NumberFormatter::CURRENCY);
    return $formatter->formatCurrency($number, $budget->currency);
}
