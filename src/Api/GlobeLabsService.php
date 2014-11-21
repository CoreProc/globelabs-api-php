<?php

namespace Coreproc\Globe\Labs\Api;

class GlobeLabsService
{

    public $appId;
    public $appSecret;

    /**
     *
     * @param $appId
     * @param $appSecret
     */
    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function call()
    {
        // call guzzle given the url
    }

}