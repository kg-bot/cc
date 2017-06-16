<?php
namespace App\Cronjobs;

require __DIR__ . '/../../vendor/autoload.php';

use App\extensions\rates\UpdateRates;

$updateRates = new UpdateRates();