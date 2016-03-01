<?php
class IntegerNet_DevDashboard_Block_Notifications extends Mage_Adminhtml_Block_Template
{
    protected $_template = 'integernet_devdashboard/notifications.phtml';

    public function isHomepage()
    {
        return 'dashboard/dev' == Mage::getStoreConfig(Mage_Admin_Model_User::XML_PATH_STARTUP_PAGE);
    }
}