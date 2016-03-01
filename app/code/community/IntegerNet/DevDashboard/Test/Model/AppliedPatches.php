<?php
use org\bovigo\vfs\vfsStream;

class IntegerNet_DevDashboard_Test_Model_AppliedPatches extends EcomDev_PHPUnit_Test_Case
{
    protected function setUp()
    {
        vfsStream::setUp('etc');
        Mage::getConfig()->getOptions()->setEtcDir(vfsStream::url('etc'));
    }
    protected function tearDown()
    {
        Mage::getConfig()->getOptions()->setEtcDir(Mage::getRoot() . DS . 'etc');
    }
    /**
     * @param $patchFileContent
     * @dataProvider dataPatchFileContent
     */
    public function testThatPatchFileCanBeParsed($patchFileContent, $expectedPatches)
    {
        file_put_contents(vfsStream::url('etc/applied.patches.list'), $patchFileContent);
        /** @var IntegerNet_DevDashboard_Model_AppliedPatches $patchModel */
        $patchModel = Mage::getModel('integernet_devdashboard/appliedPatches');
        $this->assertEquals($expectedPatches, $patchModel->getPatches());
    }
    public static function dataPatchFileContent()
    {
        return [
            ["2016-01-21 12:41:18 UTC | SUPEE-7405-CE-1-9-0-1 | CE_1.9.0.1 | v1 | ea82b89fc68d641ccb88e2a5fc816c9eba68a4d9 | Tue Jan 19 15:57:35 2016 +0200 | be76c3faa9..ea82b89fc6
patching file app/code/core/Mage/Admin/Model/Observer.php
patching file app/code/core/Mage/Admin/Model/Redirectpolicy.php
patching file app/code/core/Mage/Admin/Model/Resource/User.php
patching file app/code/core/Mage/Admin/Model/User.php
patching file app/code/core/Mage/Adminhtml/Block/Sales/Order/View/Tab/History.php
patching file app/code/core/Mage/Adminhtml/Block/Widget/Grid.php
patching file app/code/core/Mage/Adminhtml/Helper/Catalog/Product/Edit/Action/Attribute.php
patching file app/code/core/Mage/Adminhtml/Helper/Sales.php
patching file app/code/core/Mage/Adminhtml/Model/System/Config/Backend/File.php
patching file app/code/core/Mage/Adminhtml/Model/System/Config/Backend/Image.php
patching file app/code/core/Mage/Adminhtml/Model/System/Config/Backend/Image/Favicon.php
patching file app/code/core/Mage/Adminhtml/controllers/IndexController.php
/", ["SUPEE-7405"]]
        ];
    }
}