<?php

use Coreproc\Globe\Labs\Api\Services\Sms;

require 'vendor/autoload.php';

$sms = new Sms('eB75F4dyoGhRdcEqxbTyMXhR9BRBFKx8', '75ccbb7bcda7c34b649c9396c531e2a5c5ba5a94f4bacdca8c3c867528f477ab');

$sms->send('7U37uqyVYkcL6HTu40i49VxKUKUm6f89cJIEu7yEBdw', '09178436703', 'Test' , null, 2328);
