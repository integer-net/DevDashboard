<?php
class IntegerNet_DevDashboard_Block_Config_Dev extends Mage_Adminhtml_Block_System_Config_Edit
{
    protected $originalSectionParam;

    public function __construct()
    {
        $this->_prepareRequestParams();
        parent::__construct();
        $this->setTitle($this->helper('integernet_devdashboard')->__('Developer Configuration'));
        $this->_resetRequestParams();
    }
    protected function _prepareLayout()
    {
        $this->_prepareRequestParams();
        parent::_prepareLayout();
        $this->initForm();
        $this->_resetRequestParams();
        return $this;
    }

    protected function _toHtml()
    {
        return parent::_toHtml();
    }

    protected function _prepareRequestParams()
    {
        $this->originalSectionParam = $this->getRequest()->getParam('section');
        $this->getRequest()->setParam('section', 'dev');
    }

    protected function _resetRequestParams()
    {
        $this->getRequest()->setParam('section', $this->originalSectionParam);
    }

    public function getModuleName()
    {
        return 'Mage_Adminhtml';
    }

    public function getSaveUrl()
    {
        return $this->getUrl('adminhtml/system_config/save', ['section' => 'dev']);
    }

}