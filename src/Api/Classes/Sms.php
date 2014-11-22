<?php

namespace Coreproc\Globe\Labs\Api\Classes;

use Coreproc\MsisdnPh\Msisdn;
use DateTime;

class Sms
{

    /**
     * @var Msisdn
     */
    public $reciever;

    /**
     * @var string
     */
    public $message;

    /**
     * @var boolean
     */
    public $isSent;

    /**
     * @var Carbon
     */
    public $createdAt;

} 