<?php
class IntegerNet_DevDashboard_Test_Model_RequiredPatches extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var IntegerNet_DevDashboard_Model_RequiredPatches_Api|PHPUnit_Framework_MockObject_MockObject
     */
    protected $apiMock;
    /**
     * @var Mage_Core_Model_Cache|PHPUnit_Framework_MockObject_MockObject
     */
    protected $cacheMock;
    /**
     * @var IntegerNet_DevDashboard_Model_RequiredPatches
     */
    protected $patchModel;

    protected function setUp()
    {
        $this->cacheMock = $this->getModelMock('core/cache', ['load', 'save']);
        $this->apiMock = $this->getModelMock('integernet_devdashboard/requiredPatches_api', ['doRequest']);
        $this->replaceByMock('model', 'integernet_devdashboard/requiredPatches_api', $this->apiMock);
        $this->patchModel = Mage::getModel('integernet_devdashboard/requiredPatches');
        $this->patchModel->setCache($this->cacheMock);

    }

    /**
     * @dataProvider dataPatches
     * @param $dataFromApi
     * @param $expectedResult
     */
    public function testResultFromApi($dataFromApi, $expectedResult)
    {
        $this->cacheMock->method('load')->willReturn(false);
        $this->cacheMock->expects($this->once())
            ->method('save')
            ->with($dataFromApi, IntegerNet_DevDashboard_Model_RequiredPatches::CACHE_ID, [], 86400)
            ->willReturn(true);
        $this->apiMock->expects($this->once())
            ->method('doRequest')
            ->willReturn($dataFromApi);

        $this->assertEquals($expectedResult, $this->patchModel->getPatches());
    }

    /**
     * @dataProvider dataPatches
     * @param $dataFromCache
     * @param $expectedResult
     */
    public function testResultFromCache($dataFromCache, $expectedResult)
    {
        $this->cacheMock->method('load')
            ->with(IntegerNet_DevDashboard_Model_RequiredPatches::CACHE_ID)
            ->willReturn($dataFromCache);
        $this->cacheMock->expects($this->never())
            ->method('save');
        $this->apiMock->expects($this->never())
            ->method('doRequest');

        $this->assertEquals($expectedResult, $this->patchModel->getPatches());
    }

    public static function dataPatches()
    {
        return [
            [
                '{"required": ["SUPEE-6482", "SUPEE-6788", "SUPEE-7405"]}',
                ['SUPEE-6482', 'SUPEE-6788', 'SUPEE-7405']
            ]
        ];
    }
}