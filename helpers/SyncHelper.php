<?php

namespace humhub\modules\stepstone_sync\helpers;

use humhub\modules\user\models\User;
use humhub\modules\user\models\GroupUser;
use humhub\modules\user\models\Password;
use humhub\modules\user\models\Profile;
use humhub\modules\space\models\Space;
use Yii;

class SyncHelper {  
      
  // https://stackoverflow.com/questions/6101956/generating-a-random-password-in-php
  public static function generate_password() {
      $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $pass = array(); 
      $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
      for ($i = 0; $i < 8; $i++) {
          $n = random_int(0, $alphaLength);
          $pass[] = $alphabet[$n];
      }
      return implode($pass); 
  }    
     
}  


