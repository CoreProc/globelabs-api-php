<?php

namespace Coreproc\Globe\Labs\Api\Services;

class LocationService extends GlobeLabsService
{

    private $baseUrl = 'http://devapi.globelabs.com.ph/location/v1/queries/location?access_token={access_token}&address={address}&requestedAccuracy={metres}';

}