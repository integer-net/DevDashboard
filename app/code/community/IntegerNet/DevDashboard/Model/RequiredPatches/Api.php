<?php

class IntegerNet_DevDashboard_Model_RequiredPatches_Api
{
    /**
     * @param $edition
     * @param $version
     * @return string
     */
    public function doRequest($edition, $version)
    {
        $apiUrl = sprintf('https://tools.hypernode.com/patches/%s/%s', $edition, $version);
        $apiResponse = file_get_contents($apiUrl);
        return $apiResponse;
    }
}
