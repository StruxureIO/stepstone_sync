<?php

use humhub\modules\stepstone_sync\Events;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\widgets\TopMenu;
use humhub\commands\CronController;

return [
    'id' => 'stepstone_sync',
    'class' => 'humhub\modules\stepstone_sync\Module',
    'namespace' => 'humhub\modules\stepstone_sync',
    'events' => [
        //[TopMenu::class, TopMenu::EVENT_INIT, [Events::class, 'onTopMenuInit']],
        //[AdminMenu::class, AdminMenu::EVENT_INIT, [Events::class, 'onAdminMenuInit']],
        ['class' => AdminMenu::class, 'event' => AdminMenu::EVENT_INIT, 'callback' => [Events::class, 'onAdminMenuInit']],
        ['class' => CronController::class, 'event' => CronController::EVENT_BEFORE_ACTION, 'callback' => [Events::class, 'onCronDailyRun']],
        //['class' => CronController::class, 'event' => CronController::EVENT_ON_DAILY_RUN, 'callback' => [Events::class, 'onCronDailyRun']],
    ],
];
