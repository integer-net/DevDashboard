<?php
class IntegerNet_DevDashboard_Test_Block_Config_Dev extends IntegerNet_DevDashboard_Test_Block_Abstract
{
    protected $blockAlias = 'integernet_devdashboard/config_dev';
    /**
     * @var IntegerNet_DevDashboard_Block_Config_Dev
     */
    protected $block;

    /**
     * @singleton core/session
     * @singleton adminhtml/session
     */
    public function testBlock()
    {
        $this->assertInstanceOf(IntegerNet_DevDashboard_Block_Config_Dev::class, $this->block);
    }

    /**
     * @depends testBlock
     */
    public function testThatDeveloperConfigSectionIsInitialized()
    {
        $this->block->toHtml();
        $this->assertEquals('Developer Configuration', $this->block->getTitle());
        $this->assertNotFalse($this->block->getChild('form'), 'Form initialized');
        /** @var  $form Varien_Data_Form */
        $form = $this->block->getChild('form')->getForm();
        $this->assertNotNull($form->getElement('dev_restrict'), 'Form fieldset: client restriction');
        $this->assertNotNull($form->getElement('dev_debug'), 'Form fieldset: debug');
        $this->assertNotNull($form->getElement('dev_template'), 'Form fieldset: template');
        $this->assertNotNull($form->getElement('dev_translate_inline'), 'Form fieldset: inline translation');
        $this->assertNotNull($form->getElement('dev_log'), 'Form fieldset: log');
        $this->assertNotNull($form->getElement('dev_js'), 'Form fieldset: js');
        $this->assertNotNull($form->getElement('dev_css'), 'Form fieldset: css');

        $this->assertRegExp('{admin/system_config/save/(.+/)?section/dev/}', $this->block->getSaveUrl(), 'Form action');
    }

    /**
     * @depends testBlock
     */
    public function testModuleNameForTranslations()
    {
        $this->assertEquals('Mage_Adminhtml', $this->block->getModuleName(), 'Module name for translations');
    }
}