<?php
/**
 * Created by PhpStorm.
 * User: Marvin
 * Date: 23.08.2017
 * Time: 22:58
 */
include "../vendor/tplaner/when/src/When.php";
include "../vendor/tplaner/when/src/Valid.php";

$r = new When\When();
$r->startDate(new DateTime("19980213T090000"))
    ->rrule("FREQ=MONTHLY;BYDAY=FR;BYMONTHDAY=13")
    ->generateOccurrences();

print_r($r->occurrences);