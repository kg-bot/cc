<?php
namespace App\Cronjobs;

require __DIR__ . '/../../vendor/autoload.php';

use App\Extensions\Rates\UpdateRates;

$updateRates = new UpdateRates();