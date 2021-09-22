<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\stepstone_sync\codeceptionTest\functional;

use humhub\modules\stepstone_sync\codeceptionTest\FunctionalTester;

class IndexPageCest
{

    public function testTopMenu(FunctionalTester $I) {
        $I->wantTo('see top menu entry');
        $I->amUser();
        $I->amOnDashboard();
        $I->see('EXAMPLE');
    }

    public function testIndexPage(FunctionalTester $I) {
        $I->wantTo('go to module page');
        $I->amAdmin();
        $I->amOnDashboard();
        $I->click('Example');
        $I->see('This is a lead paragraph.');
    }

}
