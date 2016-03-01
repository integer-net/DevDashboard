<?php
class IntegerNet_DevDashboard_Model_RequiredPatches
{
    const CACHE_ID = 'integernet_devdashboard_patches';

    /**
     * @var Mage_Core_Model_Cache
     */
    protected $_cache;
    /**
     * @var IntegerNet_DevDashboard_Model_RequiredPatches_Api
     */
    protected $_api;

    public function __construct()
    {
        $this->_cache = Mage::app()->getCacheInstance();
        $this->_api = Mage::getModel('integernet_devdashboard/requiredPatches_api');
    }

    /**
     * @param Mage_Core_Model_Cache $cache
     * @internal for tests
     */
    public function setCache(Mage_Core_Model_Cache $cache)
    {
        $this->_cache = $cache;
    }

    /**
     * @return string[][]
     */
    public function getPatches()
    {
        if ($cachedResponse = $this->_cache->load(self::CACHE_ID)) {
            $resultAsJson = $cachedResponse;
        } else {
            $resultAsJson = $this->_fetchFromApi();
            $this->_cache->save($resultAsJson, self::CACHE_ID, [], 86400);
        }
        $resultAsArray = Mage::helper('core')->jsonDecode($resultAsJson, true);
        return $resultAsArray['required'];
    }

    /**
     * @return string
     */
    protected function _fetchFromApi()
    {
        $edition = strtolower(Mage::getEdition());
        $version = Mage::getVersion();
        return $this->_api->doRequest($edition, $version);
    }
}