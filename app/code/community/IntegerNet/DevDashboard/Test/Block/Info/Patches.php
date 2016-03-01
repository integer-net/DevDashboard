<?php
class IntegerNet_DevDashboard_Test_Block_Info_Patches extends IntegerNet_DevDashboard_Test_Block_Abstract
{
    protected $blockAlias = 'integernet_devdashboard/info_patches';

    /**
     * @var IntegerNet_DevDashboard_Block_Info_Patches
     */
    protected $block;

    /**
     * @singleton core/session
     * @singleton adminhtml/session
     */
    public function testBlock()
    {
        $this->assertInstanceOf(IntegerNet_DevDashboard_Block_Info_Patches::class, $this->block);
    }

    /**
     * @depends testBlock
     */
    public function testGetAppliedPatches()
    {
        $dataAppliedPatches = ['SUPEE-1234', 'APPSEC-666'];
        $this->mockAppliedPatchesModel($dataAppliedPatches);
        $this->assertEquals($dataAppliedPatches, $this->block->getAppliedPatches());
    }

    /**
     * @depends testBlock
     */
    public function testGetMissingPatches()
    {
        $dataRequiredPatches = ['SUPEE-0815', 'SUPEE-1234', 'SUPEE-4711'];
        $dataAppliedPatches = ['SUPEE-1234', 'APPSEC-666'];
        $expectedMissingPatches = ['SUPEE-0815', 'SUPEE-4711'];
        $this->mockAppliedPatchesModel($dataAppliedPatches);
        $this->mockRequiredPatchModel($dataRequiredPatches);
        $this->assertEquals($expectedMissingPatches, $this->block->getMissingPatches(), '', 0.0, 10, true);
    }

    /**
     * @param $dataPatches
     */
    private function mockAppliedPatchesModel($dataPatches)
    {
        $appliedPatchesClassAlias = 'integernet_devdashboard/appliedPatches';
        $patchModelMock = $this->getModelMock($appliedPatchesClassAlias, ['getPatches']);
        $patchModelMock->method('getPatches')->willReturn($dataPatches);
        $this->replaceByMock('model', $appliedPatchesClassAlias, $patchModelMock);
    }

    /**
     * @param $dataRequiredPatches
     */
    private function mockRequiredPatchModel($dataRequiredPatches)
    {
        $requiredPatchesClassAlias = 'integernet_devdashboard/requiredPatches';
        $patchModelMock = $this->getModelMock($requiredPatchesClassAlias, ['getPatches']);
        $patchModelMock->method('getPatches')->willReturn($dataRequiredPatches);
        $this->replaceByMock('model', $requiredPatchesClassAlias, $patchModelMock);
    }
}