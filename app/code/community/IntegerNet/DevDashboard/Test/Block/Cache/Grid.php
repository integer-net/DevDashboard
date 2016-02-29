<?php
class IntegerNet_DevDashboard_Test_Block_Cache_Grid extends IntegerNet_DevDashboard_Test_Block_Abstract
{
    protected $blockAlias = 'integernet_devdashboard/cache_grid';
    /**
     * @var IntegerNet_DevDashboard_Block_Cache_Grid
     */
    protected $block;

    /**
     * @singleton core/session
     * @singleton adminhtml/session
     */
    public function testBlock()
    {
        $this->assertInstanceOf(IntegerNet_DevDashboard_Block_Cache_Grid::class, $this->block);
    }

    /**
     * @depends testBlock
     */
    public function testChangedGrid()
    {
        $this->block->toHtml();
        $this->assertGridIsReduced();
        $this->assertGridHasActionsColumn();
    }

    /**
     * @depends testBlock
     */
    public function testModuleNameForTranslations()
    {
        $this->assertEquals('Mage_Adminhtml', $this->block->getModuleName(), 'Module name for translations');
    }

    private function assertGridIsReduced()
    {
        $actualColumns = $this->block->getColumns();
        $this->assertArrayNotHasKey('tags', $actualColumns);
        $this->assertArrayNotHasKey('description', $actualColumns);
        $this->assertEmpty($this->block->getMassactionBlock()->getItems(), 'Mass action items');
    }

    private function assertGridHasActionsColumn()
    {
        $actualColumns = $this->block->getColumns();
        $this->assertArrayHasKey('actions', $actualColumns);
    }

}