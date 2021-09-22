<?php

use humhub\modules\stepstone_sync\Events;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\widgets\TopMenu;

return [
    'id' => 'stepstone_sync',
    'class' => 'humhub\modules\stepstone_sync\Module',
    'namespace' => 'humhub\modules\stepstone_sync',
    'events' => [
        //[TopMenu::class, TopMenu::EVENT_INIT, [Events::class, 'onTopMenuInit']],
        [AdminMenu::class, AdminMenu::EVENT_INIT, [Events::class, 'onAdminMenuInit']]
    ],
];
