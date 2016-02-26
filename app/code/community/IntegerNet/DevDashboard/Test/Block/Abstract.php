<?php
require_once 'IntegerNet/DevDashboard/controllers/Adminhtml/DevdashboardController.php';
abstract class IntegerNet_DevDashboard_Test_Block_Abstract extends EcomDev_PHPUnit_Test_Case
{
    protected $blockAlias = 'integernet_devdashboard/config_dev';
    protected $block;

    /**
     * @param $sessionModel
     */
    protected function replaceSessionWithDummy($sessionModel)
    {
        $this->replaceByMock('singleton', $sessionModel, $this->getModelMock($sessionModel));
    }

    protected function setUp()
    {
        $this->replaceSessionWithDummy('core/session');
        $this->replaceSessionWithDummy('adminhtml/session');
        $this->app()->getFrontController()->setAction(new IntegerNet_DevDashboard_Adminhtml_DevdashboardController(
            $this->app()->getRequest(), $this->app()->getResponse()
        ));
        $layout = $this->app()->getLayout();
        $this->block = $layout->createBlock($this->blockAlias);
        $this->block->getLayout()->setArea(Mage_Core_Model_App_Area::AREA_ADMINHTML);
    }

}