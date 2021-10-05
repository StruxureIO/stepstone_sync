<?php

namespace humhub\modules\stepstone_sync;

use humhub\modules\admin\permissions\ManageModules;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\modules\ui\menu\MenuLink;
use humhub\widgets\TopMenu;
use Yii;
use yii\base\Event;
use humhub\modules\stepstone_sync\jobs\SyncDaily;


class Events
{
    /**
     * Defines what to do when the top menu is initialized.
     *
     * @param $event
     *
     * @return void
     */
    public static function onTopMenuInit($event): void
    {
        /** @var TopMenu $topMenuWidget */
        $topMenuWidget = $event->sender;

        $topMenuWidget->addEntry(new MenuLink([
            'label' => Yii::t('StepstoneSyncModule.base', 'StepStone Sync'),
            'icon' => 'anchor',
            'url' => ['/stepstone_sync/index'],
            'sortOrder' => 99999,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'stepstone_sync' && Yii::$app->controller->id == 'index'),
        ]));
    }

    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param $event Event
     *
     * @return void
     */
    public static function onAdminMenuInit($event): void
    {
        /** @var AdminMenu $adminMenuWidget */
        $adminMenuWidget = $event->sender;

        $adminMenuWidget->addEntry(new MenuLink([
            'label' => Yii::t('StepstoneSyncModule.base', 'StepStone Sync'),
            'url' => ['/stepstone_sync/admin'],
            'icon' => 'fa-sync-alt', 
            'sortOrder' => 1000,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'stepstone_sync' && Yii::$app->controller->id == 'admin'),
            'isVisible' => Yii::$app->user->can(ManageModules::class)
        ]));
    }

    // to run
    // run the cron: php yii cron/run
    // then run the queue: php yii queue/run
    public static function onCronDailyRun($event)
    {      
      $auto_update = Yii::$app->getModule('stepstone_sync')->settings->get('auto-update');          
      
      if($auto_update == 'true') {
        
        $module = Yii::$app->getModule('stepstone_sync');
        $lastRunAgentSyncCron = $module->settings->get('lastRunAgentSyncCron');

        if(!$lastRunAgentSyncCron || time() >= ($lastRunAgentSyncCron + 86400)) { // 24 hours 86400
          try {
            Yii::$app->queue->push( new SyncDaily());
          } catch (\Throwable $e) {
            Yii::error($e);
          }
          $module->settings->set('lastRunAgentSyncCron', time());
        }          
        
      }
      
    }
    
}
