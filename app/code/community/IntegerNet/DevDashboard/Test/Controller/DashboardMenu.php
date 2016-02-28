<?php
class IntegerNet_DevDashboard_Test_Controller_DashboardMenu extends EcomDev_PHPUnit_Test_Case_Controller
{
    private function openSalesPageWithPrivileges(array $privileges)
    {
        $this->adminSession($privileges);
        $this->dispatch('adminhtml/sales_order/index');
    }

    private function assertDasboardMenuItemVisible($visible = true)
    {
        $expectedUrl = 'http://magento.local/index.php/admin/devdashboard/index/';
        $constraint = $this->matchesRegularExpression(
            '{href="'.$expectedUrl.'[^"]*"[^>]*>\s*<span>Developer Dashboard</span>}'
        );
        if (!$visible) {
            $constraint = $this->logicalNot($constraint);
        }
        $this->assertResponseBody($constraint);
    }

    public function testThatMenuIsVisibleForRoot()
    {
        $allPrivileges  = [];
        $this->openSalesPageWithPrivileges($allPrivileges);
        $this->assertDasboardMenuItemVisible(true);
    }

    public function testThatMenuIsVisibleForPrivilegedUser()
    {
        $this->openSalesPageWithPrivileges(['sales/order', 'dashboard', 'dashboard/dev']);
        $this->assertDasboardMenuItemVisible(true);
    }

    public function testThatMenuIInVisibleForRestrictedUser()
    {
        $this->openSalesPageWithPrivileges(['sales/order']);
        $this->assertResponseBodyNotContains('Developer Dashboard');
        $this->assertDasboardMenuItemVisible(false);
    }

}