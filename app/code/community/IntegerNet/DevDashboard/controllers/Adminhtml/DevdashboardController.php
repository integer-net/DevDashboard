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