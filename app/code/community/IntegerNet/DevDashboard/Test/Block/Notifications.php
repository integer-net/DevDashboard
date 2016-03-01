<?php
class IntegerNet_DevDashboard_Test_Block_Notifications extends IntegerNet_DevDashboard_Test_Block_Abstract
{
    protected $blockAlias = 'integernet_devdashboard/notifications';
    /**
     * @var IntegerNet_DevDashboard_Block_Notifications
     */
    protected $block;

    /**
     * @singleton core/session
     * @singleton adminhtml/session
     */
    public function testBlock()
    {
        $this->assertInstanceOf(IntegerNet_DevDashboard_Block_Notifications::class, $this->block);
    }

    public function testIsHomepage()
    {
        $this->app()->getStore()->setConfig(Mage_Admin_Model_User::XML_PATH_STARTUP_PAGE, 'dashboard');
        $this->assertFalse($this->block->isHomepage(), 'isHomepage should return false');

        $this->app()->getStore()->setConfig(Mage_Admin_Model_User::XML_PATH_STARTUP_PAGE, 'dashboard/dev');
        $this->assertTrue($this->block->isHomepage(), 'isHomepage should return false');
    }
}