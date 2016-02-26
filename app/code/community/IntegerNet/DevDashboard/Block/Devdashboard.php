<?php
class IntegerNet_DevDashboard_Block_Devdashboard extends Mage_Adminhtml_Block_Template
{
    protected $_template = 'integernet_devdashboard/index.phtml';

    /**
     * Check if symlinks are allowed
     *
     * @return string
     */
    public function _toHtml()
    {
        $html = parent::_toHtml();
        if (!$html && !Mage::getStoreConfigFlag('dev/template/allow_symlink')) {
            $url = $this->getUrl('adminhtml/system_config/edit', array('section' => 'dev')) . '#dev_template';
            $html = '<ul class="messages"><li class="warning-msg">' . $this->__('Warning: You installed <strong>Developer Dashboard</strong> using symlinks (e.g. via modman), but forgot to allow symlinks for template files! Please go to <a href="%s">System > Configuration > Advanced > Developer > Template Settings</a> and set "Allow Symlinks" to "yes"', $url) . '</li></ul>';
        }
        return $html;
    }
}