<?php

/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
class IntegerNet_DevDashboard_Block_Info_System extends Mage_Adminhtml_Block_Template
{
    protected $_template = 'integernet_devdashboard/info/system.phtml';

    public function getPhpVersion()
    {
        return PHP_VERSION;
    }

    public function getXDebugEnabled()
    {
        return extension_loaded('xdebug');
    }


}