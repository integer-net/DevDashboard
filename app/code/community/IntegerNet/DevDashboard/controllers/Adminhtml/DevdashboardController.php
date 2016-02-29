<?php
class IntegerNet_DevDashboard_Adminhtml_DevdashboardController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /*
     * @todo new controller that extends Mage_Adminhtml_System_ConfigController to redirect back or allow ajax
     */


    /**
     * Refresh single cache type
     */
    public function refreshCacheAction()
    {
        $type = $this->getRequest()->getParam('type');
        Mage::app()->getCacheInstance()->cleanType($type);
        Mage::dispatchEvent('adminhtml_cache_refresh_type', array('type' => $type));
        $this->_getSession()->addSuccess(Mage::helper('adminhtml')->__("%s cache type(s) refreshed.", 1));
        $this->_redirect('*/*');
    }

    /**
     * Enable/Disable single cache type
     */
    public function toggleCacheAction()
    {
        $type = $this->getRequest()->getParam('type');
        $allTypes = Mage::app()->useCache();
        $allTypes[$type] = 1 - $allTypes[$type];
        Mage::app()->saveUseCache($allTypes);
        if (! $allTypes[$type]) {
            Mage::app()->getCacheInstance()->cleanType($type);
        }
        $message = $allTypes[$type] ? "%s cache type(s) enabled." : "%s cache type(s) disabled.";
        $this->_getSession()->addSuccess(Mage::helper('adminhtml')->__($message, 1));
        $this->_redirect('*/*');


    }
    /*
     * Actions from Mage_Adminhtml_CacheController for proper redirection
     *
     * @todo extract to own controller that extends Mage_Adminhtml_CacheController
     * @todo ajax actions
     */

    /**
     * Flush cache storage
     */
    public function flushAllAction()
    {
        Mage::dispatchEvent('adminhtml_cache_flush_all');
        Mage::app()->getCacheInstance()->flush();
        $this->_getSession()->addSuccess(Mage::helper('adminhtml')->__("The cache storage has been flushed."));
        $this->_redirect('*/*');
    }

    /**
     * Flush all magento cache
     */
    public function flushSystemAction()
    {
        Mage::app()->cleanCache();
        Mage::dispatchEvent('adminhtml_cache_flush_system');
        $this->_getSession()->addSuccess(Mage::helper('adminhtml')->__("The Magento cache storage has been flushed."));
        $this->_redirect('*/*');
    }

}