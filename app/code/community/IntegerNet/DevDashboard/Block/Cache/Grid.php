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
        $this->addColumn('actions',
            array(
                'header'    =>  $this->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => $this->__('Refresh'),
                        'url'       => array('base'=> '*/*/refreshCache'),
                        'field'     => 'type'
                    ),
                    array(
                        'caption'   => $this->__('Enable') . '/' . $this->__('Disable'),
                        'url'       => array('base'=> '*/*/toggleCache'),
                        'field'     => 'type'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'is_system' => true,
        ));

        return $this;
    }
    protected function _prepareMassaction()
    {
        return;
    }

    public function getModuleName()
    {
        return 'Mage_Adminhtml';
    }

}