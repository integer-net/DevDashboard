<?php
class IntegerNet_DevDashboard_Test_Controller_DashboardController extends EcomDev_PHPUnit_Test_Case_Controller
{
    private $route = 'adminhtml/devdashboard/index';

    private function loadDashboard($params = [])
    {
        $this->adminSession();
        $this->dispatch($this->route, $params);
    }

    /**
     * @param $type
     * @param $optionsBefore
     * @param $expectedOptions
     * @param string|null $expectedCleanType
     */
    private function doToggleCacheAction($type, $optionsBefore, $expectedOptions, $expectedCleanType = null)
    {
        $this->adminSession();
        $route = 'adminhtml/devdashboard/toggleCache';
        $cacheMock = $this->mockCache(['saveOptions', 'cleanType']);
        $cacheMock->expects($this->once())
            ->method('saveOptions')
            ->with($expectedOptions);
        if ($expectedCleanType) {
            $cacheMock->expects($this->once())
                ->method('cleanType')
                ->with($expectedCleanType);
        }
        $this->app()->setCacheOptions($optionsBefore);
        $this->dispatch($route, ['type' => $type]);
        $this->assertRequestRoute($route);
        $this->assertRedirectTo($this->route);
    }

    private function setConfig($path, $value)
    {
        $this->app()->getStore(Mage_Core_Model_App::ADMIN_STORE_ID)->setConfig($path, $value);
    }

    /**
     * @param string[] $methods
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function mockCache(array $methods)
    {
        $cacheMock = $this->getModelMockBuilder('core/cache')->setMethods($methods)->getMock();
        $this->replaceByMock('model', 'core/cache', $cacheMock);
        $this->app()->initTest();
        return $cacheMock;
    }

    /**
     * @singleton index/indexer
     */
    public function testThatDevDashboardLoads()
    {
        $this->setConfig('dev/template/allow_symlink', '1');
        $this->loadDashboard();
        $this->assertRequestRoute($this->route);
        $this->assertLayoutLoaded();
        $this->assertLayoutHandleLoaded('adminhtml_devdashboard_index');
        $this->assertLayoutRendered();
        $this->assertLayoutBlockRendered('devdashboard');
        $this->assertLayoutBlockRenderedContentNot('devdashboard', $this->stringContains('modman'));
        $this->assertLayoutBlockRendered('devdashboard_left');
        $this->assertLayoutBlockRendered('devdashboard_right');

        $this->assertLayoutBlockRendered('devdashboard_cache');
        $this->assertLayoutBlockRendered('devdashboard_info_system');
        $this->assertLayoutBlockRendered('devdashboard_info_magento');

        $this->assertLayoutBlockRendered('devdashboard_store_switcher');
        $this->assertLayoutBlockRendered('devdashboard_config_dev');

    }

    /**
     * @singleton index/indexer
     */
    public function testStoreSwitcher()
    {
        $this->loadDashboard(['website' => 'base']);
        $this->assertLayoutBlockRenderedContent('devdashboard_store_switcher',
            $this->matchesRegularExpression('{<option [^>]*value="website_base"[^>]*selected="selected"}'));
    }

    /**
     * @singleton index/indexer
     */
    public function testSymlinkWarning()
    {
        $this->setConfig('dev/template/allow_symlink', '0');
        $this->loadDashboard();
        $this->assertLayoutBlockRenderedContent('devdashboard', $this->stringContains('modman'));
    }
    /**
     * @singleton adminhtml/session
     */
    public function testFlushCacheAction()
    {
        $this->adminSession();
        $this->mockCache(['flush'])->expects($this->once())->method('flush')->with();


        $this->dispatch('adminhtml/devdashboard/flushAll');
        $this->assertEventDispatchedExactly('adminhtml_cache_flush_all', 1);
        $this->assertRedirectTo($this->route);
    }
    /**
     * @singleton adminhtml/session
     */
    public function testFlushSystemAction()
    {
        $this->adminSession();
        $this->mockCache(['clean'])->expects($this->once())->method('clean')->with([]);

        $this->dispatch('adminhtml/devdashboard/flushSystem');
        $this->assertEventDispatchedExactly('adminhtml_cache_flush_system', 1);
        $this->assertEventDispatchedExactly('application_clean_cache', 1);
        $this->assertRedirectTo($this->route);
    }
    /**
     * @singleton adminhtml/session
     */
    public function testRefreshCacheAction()
    {
        $this->adminSession();
        $type = 'translate';
        $route = 'adminhtml/devdashboard/refreshCache';
        $cacheMock = $this->mockCache(['cleanType']);
        $cacheMock->expects($this->once())
            ->method('cleanType')
            ->with($type);
        $this->dispatch($route, ['type' => $type]);
        $this->assertRequestRoute($route);
        $this->assertRedirectTo($this->route);
        $this->assertEventDispatchedExactly('adminhtml_cache_refresh_type', 1);
    }
    /**
     * @singleton adminhtml/session
     */
    public function testThatToggleCacheActionTurnsCacheOn()
    {
        $this->doToggleCacheAction('translate', [
            'eav' => 0,
            'layout' => 0,
            'translate' => 0
        ], [
            'eav' => 0,
            'layout' => 0,
            'translate' => 1
        ]);
    }
    /**
     * @singleton adminhtml/session
     */
    public function testThatToggleCacheActionTurnsCacheOff()
    {
        $this->doToggleCacheAction('translate', [
            'eav' => 1,
            'layout' => 1,
            'translate' => 1
        ], [
            'eav' => 1,
            'layout' => 1,
            'translate' => 0,
        ], 'translate');
    }

    /**
     * Assert that layout block rendered content is evaluated by constraint
     *
     * Overridden due to wrong constant in original method
     *
     * @param string $blockName
     * @param PHPUnit_Framework_Constraint $constraint
     * @param string $message
     */
    public static function assertLayoutBlockRenderedContent($blockName,
                                                            PHPUnit_Framework_Constraint $constraint, $message = '')
    {
        self::assertThatLayout(
            self::layoutBlock(
                $blockName,
                EcomDev_PHPUnit_Constraint_Layout_Block::TYPE_RENDERED_CONTENT,
                $constraint
            ),
            $message
        );
    }

    /**
     * Assert that layout block rendered content is not evaluated by constraint
     *
     * Overridden due to wrong constant in original method
     *
     * @param string $blockName
     * @param PHPUnit_Framework_Constraint $constraint
     * @param string $message
     */
    public static function assertLayoutBlockRenderedContentNot($blockName,
                                                               PHPUnit_Framework_Constraint $constraint, $message = '')
    {
        self::assertThatLayout(
            self::layoutBlock(
                $blockName,
                EcomDev_PHPUnit_Constraint_Layout_Block::TYPE_RENDERED_CONTENT,
                self::logicalNot($constraint)
            ),
            $message
        );
    }
}