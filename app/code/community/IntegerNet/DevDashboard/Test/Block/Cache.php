<?php
class IntegerNet_DevDashboard_Test_Block_Cache extends IntegerNet_DevDashboard_Test_Block_Abstract
{
    protected $blockAlias = 'integernet_devdashboard/cache';
    /**
     * @var IntegerNet_DevDashboard_Block_Cache
     */
    protected $block;

    /**
     * @singleton core/session
     * @singleton adminhtml/session
     */
    public function testBlock()
    {
        $this->assertInstanceOf(IntegerNet_DevDashboard_Block_Cache::class, $this->block);
    }

    /**
     * @depends testBlock
     */
    public function testThatGridBlockIsReplaced()
    {
        $this->assertInstanceOf(IntegerNet_DevDashboard_Block_Cache_Grid::class, $this->block->getChild('grid'));
    }

    /**
     * @depends testBlock
     */
    public function testModuleNameForTranslations()
    {
        $this->assertEquals('Mage_Adminhtml', $this->block->getModuleName(), 'Module name for translations');
    }

}