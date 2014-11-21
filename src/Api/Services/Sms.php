<?php

namespace Coreproc\Globe\Labs\Api\Services;

use Coreproc\Globe\Labs\Api\GlobeLabsService;
use Coreproc\MsisdnPh\Msisdn;
use GuzzleHttp\Client;

class Sms extends GlobeLabsService
{

    /**
     * @var string
     */
    private $accessToken = null;

    /**
     * @var string
     */
    private $message = null;

    /**
     * @var string
     */
    private $clientCorrelator = null;

    /**
     * @var string
     */
    private $mobileNumber = null;

    /**
     * @var Msisdn
     */
    private $msisdn = null;

    /**
     * @var string
     */
    private $senderAddress = null;

    /**
     * Base url of the API
     *
     * @var string
     */
    private $baseUrl = 'http://devapi.globelabs.com.ph/smsmessaging/v1/outbound/{senderAddress}/requests?access_token={access_token}';

    /**
     * @param null $accessToken This is obtained from the user going through the consent flow
     * @param null $mobileNumber is the subscriber MSISDN (mobile number)
     * @param null $message
     * @param null $clientCorrelator
     *
     * @return bool Sent or not
     */
    public function send($accessToken, $mobileNumber, $message, $clientCorrelator = null, $senderAddress) {
        if (!empty($accessToken)) {
            $this->accessToken = $accessToken;
        }
        if (!empty($mobileNumber)) {
            $this->mobileNumber = $mobileNumber;
        }
        if (!empty($message)) {
            $this->message = $message;
        }
        if (!empty($clientCorrelator)) {
            $this->clientCorrelator = $clientCorrelator;
        }

        if(!empty($senderAddress)) {
            $this->senderAddress = $senderAddress;
        }

        $this->msisdn = new Msisdn($this->mobileNumber);
        if (!$this->msisdn->isValid()) {
            return false;
        }

        $data = [
            'outboundSMSMessageRequest' => [
                'clientCorrelator'       => '' . isset($this->clientCorrelator) ? $this->clientCorrelator : time(),
                'senderAddress'          => 'tel:' . $this->senderAddress,
                'outboundSMSTextMessage' => [
                    'message' => $this->message
                ],
                'address'                => [
                    'tel:+' . $this->msisdn->get(true)
                ]
            ]
        ];

        try {
            $client = new Client();

            $response = $client->post($this->buildUrl(), [
                'json' => $data
            ]);

            if ($response->getStatusCode() != 201) {
                return false;
            }

        } catch (\GuzzleHttp\Exception\ClientException $e) {

            return false;
        }

        return true;
    }

    private function buildUrl() {
        $url = str_replace('{senderAddress}', $this->senderAddress, $this->baseUrl);
        $url = str_replace('{access_token}', $this->accessToken, $url);

        return $url;
    }

}
