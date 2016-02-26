<?php

/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
class IntegerNet_DevDashboard_Block_Cache extends Mage_Adminhtml_Block_Cache
{
    protected $_blockGroup = 'integernet_devdashboard';

    public function getModuleName()
    {
        return 'Mage_Adminhtml';
    }

}