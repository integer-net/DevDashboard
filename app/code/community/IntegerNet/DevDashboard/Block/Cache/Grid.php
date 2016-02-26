<?php

/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
class IntegerNet_DevDashboard_Block_Cache_Grid extends Mage_Adminhtml_Block_Cache_Grid
{
    protected function _prepareColumns()
    {
        parent::_prepareColumns();
        $this->removeColumn('tags');
        $this->removeColumn('description');
        return $this;
    }
    protected function _prepareMassaction()
    {

    }

    public function getModuleName()
    {
        return 'Mage_Adminhtml';
    }

}