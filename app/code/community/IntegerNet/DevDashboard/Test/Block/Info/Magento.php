<?php
class IntegerNet_DevDashboard_Test_Block_Info_Magento extends IntegerNet_DevDashboard_Test_Block_Abstract
{
    protected $blockAlias = 'integernet_devdashboard/info_magento';

    /**
     * @var IntegerNet_DevDashboard_Block_Info_Magento
     */
    protected $block;

    /**
     * @singleton core/session
     * @singleton adminhtml/session
     */
    public function testBlock()
    {
        $this->assertInstanceOf(IntegerNet_DevDashboard_Block_Info_Magento::class, $this->block);
    }

    /**
     * @depends testBlock
     */
    public function testGetDeveloperMode()
    {
        Mage::setIsDeveloperMode(true);
        $this->assertTrue($this->block->getDeveloperMode());
        Mage::setIsDeveloperMode(false);
        $this->assertFalse($this->block->getDeveloperMode());
    }
}