<?php

require '../vendor/autoload.php';

use Coreproc\Globe\Labs\Api\Services\SmsService;

$sms = SmsService::recieveSms();

file_put_contents('example/incoming.txt', json_encode($sms));