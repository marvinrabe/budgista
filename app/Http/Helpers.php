<?php

function format_currency($number, App\Models\Budget $budget)
{
    $formatter = new NumberFormatter(Locale::getDefault(), NumberFormatter::CURRENCY);
    return $formatter->formatCurrency($number, $budget->currency);
}

function format_month(\App\Month $month) {
    $formatter = new IntlDateFormatter(Locale::getDefault(), IntlDateFormatter::FULL, IntlDateFormatter::NONE, NULL, NULL, 'MMMM yyyy');
    return $formatter->format($month->firstDay());
}