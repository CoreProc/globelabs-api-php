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
    private $shortCode = null;

    /**
     * Base url of the API
     *
     * @var string
     */
    private $baseUrl = 'http://devapi.globelabs.com.ph/smsmessaging/v1/outbound/{senderAddress}/requests?access_token={access_token}';

    /**
     * @param string $accessToken This is obtained from the user going through the consent flow
     * @param string $mobileNumber is the subscriber MSISDN (mobile number)
     * @param string $message
     * @param string $shortCode Your whole short code
     * @param string|int $clientCorrelator
     *
     * @return bool Sent or not
     */
    public function send($accessToken = null, $mobileNumber = null, $message = null, $shortCode = null, $clientCorrelator = null)
    {
        if ( ! empty($accessToken)) {
            $this->accessToken = $accessToken;
        }
        if ( ! empty($mobileNumber)) {
            $this->mobileNumber = $mobileNumber;
        }
        if ( ! empty($message)) {
            $this->message = $message;
        }
        if ( ! empty($clientCorrelator)) {
            $this->clientCorrelator = $clientCorrelator;
        }
        if ( ! empty($shortCode)) {
            $this->shortCode = $shortCode;
        }

        $requiredFields = [
            'accessToken',
            'mobileNumber',
            'message',
            'shortCode',
        ];

        foreach ($requiredFields as $r) {
            if (is_null($r)) {
                // these fields are required
                return false;
            }
        }

        $this->msisdn = new Msisdn($this->mobileNumber);
        if ( ! $this->msisdn->isValid()) {
            return false;
        }

        $data = [
            'outboundSMSMessageRequest' => [
                'clientCorrelator'       => '' . isset($this->clientCorrelator) ? $this->clientCorrelator : time(),
                'senderAddress'          => 'tel:' . substr($this->shortCode, -4),
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

    private function buildUrl()
    {
        $url = str_replace('{senderAddress}', substr($this->shortCode, -4), $this->baseUrl);
        $url = str_replace('{access_token}', $this->accessToken, $url);

        return $url;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param mixed $appId
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    /**
     * @return mixed
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    /**
     * @param mixed $appSecret
     */
    public function setAppSecret($appSecret)
    {
        $this->appSecret = $appSecret;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    public function getClientCorrelator()
    {
        return $this->clientCorrelator;
    }

    /**
     * @param string $clientCorrelator
     */
    public function setClientCorrelator($clientCorrelator)
    {
        $this->clientCorrelator = $clientCorrelator;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    /**
     * @param string $mobileNumber
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return Msisdn
     */
    public function getMsisdn()
    {
        return $this->msisdn;
    }

    /**
     * @param Msisdn $msisdn
     */
    public function setMsisdn($msisdn)
    {
        $this->msisdn = $msisdn;
    }

    /**
     * @return string
     */
    public function getShortCode()
    {
        return $this->shortCode;
    }

    /**
     * @param string $shortCode
     */
    public function setShortCode($shortCode)
    {
        $this->shortCode = $shortCode;
    }

}
