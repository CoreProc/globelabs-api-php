<?php

namespace Coreproc\Globe\Labs\Api\Receivers;

use Carbon\Carbon;
use Coreproc\Globe\Labs\Api\Classes\Sms;
use Coreproc\MsisdnPh\Msisdn;

class SmsReceiver
{

    /**
     * @param $function
     * @return bool
     */
    public static function receive($function)
    {
        $jsonStringData = file_get_contents('php://input');

        if (empty($jsonStringData)) {
            return false;
        }

        $data = json_decode($jsonStringData);

        if (empty($data)) {
            return false;
        }

        $inboundSmsMessage = $data->inboundSMSMessageList->inboundSMSMessage[0];

        if (empty($inboundSmsMessage)) {
            return false;
        }

        $sms = new Sms();
        $sms->messageId = $inboundSmsMessage->messageId;
        $sms->sender = new Msisdn($inboundSmsMessage->senderAddress);
        $sms->message = $inboundSmsMessage->message;
        $sms->createdAt = new Carbon($inboundSmsMessage->dateTime);

        // ok, now that we have the message, we can parse

        $function($sms);

        return true;
    }

}