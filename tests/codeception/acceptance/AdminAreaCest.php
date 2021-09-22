<?php

namespace humhub\modules\stepstone_sync\codeceptionTest\acceptance;

use humhub\modules\stepstone_sync\codeceptionTest\AcceptanceTester;

class AdminAreaCest
{

    public function testAdminInfoPage(AcceptanceTester $I)
    {
        $I->wantTo('see admin info page');
        $I->amAdmin();
        $I->amOnRoute(['/stepstone_sync/admin/index']);
        $I->waitForText('Welcome to the admin only area.');
    }

}
