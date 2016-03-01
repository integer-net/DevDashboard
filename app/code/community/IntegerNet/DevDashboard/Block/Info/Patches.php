<?php
class IntegerNet_DevDashboard_Block_Info_Patches extends Mage_Adminhtml_Block_Template
{
    protected $_template = 'integernet_devdashboard/info/patches.phtml';
    protected $_appliedPatches;

    public function getAppliedPatches()
    {
        if ($this->_appliedPatches === null) {
            $this->_appliedPatches = Mage::getModel('integernet_devdashboard/appliedPatches')->getPatches();
        }
        return $this->_appliedPatches;
    }

    public function getMissingPatches()
    {
        return array_diff(
            Mage::getModel('integernet_devdashboard/requiredPatches')->getPatches(),
            $this->getAppliedPatches());
    }
}