<?php 
require '../vendor/autoload.php';

use Carbon\Carbon;
$dt = Carbon::now();
echo $dt->addSeconds();

$dt = Carbon::now();
echo $dt->subSeconds();