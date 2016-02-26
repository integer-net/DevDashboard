<?php
class IntegerNet_DevDashboard_Test_Block_Info_System extends IntegerNet_DevDashboard_Test_Block_Abstract
{
    protected $blockAlias = 'integernet_devdashboard/info_system';

    /**
     * @var IntegerNet_DevDashboard_Block_Info_System
     */
    protected $block;

    /**
     * @singleton core/session
     * @singleton adminhtml/session
     */
    public function testBlock()
    {
        $this->assertInstanceOf(IntegerNet_DevDashboard_Block_Info_System::class, $this->block);
    }

    /**
     * @depends testBlock
     */
    public function testGetInfo()
    {
        $this->assertEquals(PHP_VERSION, $this->block->getPhpVersion());
        $this->assertEquals(function_exists('xdebug_is_enabled'), $this->block->getXDebugEnabled());
    }
}