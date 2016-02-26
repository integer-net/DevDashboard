<?php
class IntegerNet_DevDashboard_Test_Controller_DashboardController extends EcomDev_PHPUnit_Test_Case_Controller
{
    private $route = 'adminhtml/devdashboard/index';

    private function loadDashboard()
    {
        $this->adminSession();
        $this->dispatch($this->route);
    }

    private function setConfig($path, $value)
    {
        $this->app()->getStore(Mage_Core_Model_App::ADMIN_STORE_ID)->setConfig($path, $value);
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
        $this->assertLayoutBlockRendered('devdashboard_config_dev');
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