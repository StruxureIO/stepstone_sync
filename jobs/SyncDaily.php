<?php

namespace humhub\modules\stepstone_sync\jobs;

use humhub\modules\stepstone_sync\Events;
use humhub\modules\stepstone_sync\helpers\SyncHelper;
use humhub\modules\stepstone_sync\models\Import;
use humhub\modules\queue\ActiveJob;
use humhub\modules\user\models\User;
use humhub\modules\user\models\GroupUser;
use humhub\modules\user\models\Password;
use humhub\modules\user\models\Profile;
use humhub\modules\space\models\Space;
use Yii;
use yii\db\Query;

class SyncDaily extends ActiveJob
{
  public function run() {
      
    echo "Running daily agent sync";

    $selected_spaces_names = Yii::$app->getModule('stepstone_sync')->settings->get('selected-spaces-names');    
    $spaces_names = explode(';', $selected_spaces_names);            

    Yii::$app->db->createCommand()->truncateTable('import')->execute();      

    $html = '';

    $sync_user_name = Yii::$app->getModule('stepstone_sync')->settings->get('user');

    $sync_user_password = Yii::$app->getModule('stepstone_sync')->settings->get('password');

    $sync_token = Yii::$app->getModule('stepstone_sync')->settings->get('token');

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.stepstoneadmin.com/clients',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_POSTFIELDS =>'{"email": "'.$sync_user_name.'", "password": "'.$sync_user_password.'" }',  
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $sync_token
      ),
    ));

    $response = curl_exec($curl);

    $json_response = json_decode($response, true);
    //print_r($json_response['data']);

    //curl_close($curl);
    //die();

    foreach($json_response['data'] as $agent) {
      //$html .= "<p>". $agent['first_name'] ."</p>";        
      $import = new \humhub\modules\stepstone_sync\models\Import();
      $import->data = json_encode($agent);
      $import->save(false);
    }
    echo "Done saving agent info.";        

    curl_close($curl);

    // get name of spaces to add agents
    $selected_spaces_names = Yii::$app->getModule('stepstone_sync')->settings->get('selected-spaces-names');    
    $spaces_names = explode(';', $selected_spaces_names);            

    //query records
    $connection = Yii::$app->getDb();      

    $command = $connection->createCommand("select * from import order by id");

    $rows = $command->queryAll();  

    $counter = 0;

    if($rows) {
      foreach ($rows as $row) {
        try {
          $counter++;
          //SyncHelper::syncAgent($row, $spaces_names);

            $agent = json_decode($row['data'], true);        

            //echo "$counter " . $agent['email'] . PHP_EOL;

            $user = User::findOne(['email' => $agent['email']]);

            if($user == null ) {
              // new user
              $message = 'Adding user ' . $agent['first_name'] . " " . $agent['email'];

              $user = new User();
              $user->scenario = 'registration';

              $profile = $user->profile;
              $profile->scenario = 'registration';

              $user->username = $agent['email'];
              $user->email = $agent['email'];

              $user->status = User::STATUS_ENABLED;

              $profile->firstname = $agent['first_name'];
              $profile->lastname = $agent['last_name'];
              $profile->phone_private = $agent['phone'];

              $new_password = SyncHelper::generate_password();
              $userPassword = new Password();
              $userPassword->setPassword($new_password);

              if($user->save()) { 

                $newGroupUser = new GroupUser();
                $newGroupUser->user_id = $user->id;
                $newGroupUser->group_id = 2;
                $newGroupUser->created_at = date('Y-m-d G:i:s');
                $newGroupUser->created_by = Yii::$app->user->id;
                $newGroupUser->is_group_manager = false;
                $newGroupUser->save();

                $profile->user_id = $user->id;

                $profile->market = $agent['market'];
                $profile->captain_status = $agent['captain_status'];
                $profile->supervising_broker_status = $agent['supervising_broker_status'];
                $profile->commerical_supervisor_status = $agent['commercial_supervisor_status'];
                $profile->broker = $agent['is_broker'];
                $profile->partner = $agent['is_partner'];

                //$profile->sponsorship_date = $agent[''];
                //$profile->market_other_selection = $agent[''];
                //$profile->license_date = $agent[''];
                //$profile->listing_property_experience = $agent[''];
                //$profile->working_with_buyers_experience = $agent[''];
                //$profile->experience_with_investing = $agent[''];
                //$profile->investment_deals_other_selection = $agent[''];
                //$profile->investment_deals = $agent[''];
                //$profile->funds_available = $agent[''];
                //$profile->language_spoken_other_selection = $agent[''];
                //$profile->language_spoken = $agent[''];
                //$profile->list_property_for_seller = $agent[''];
                //$profile->pay_referral_fees = $agent[''];
                //$profile->work_with_buyers = $agent[''];
                //$profile->wholesaler = $agent[''];
                //$profile->deals_from_wholesalers = $agent[''];
                //$profile->mentor_listing_property = $agent[''];
                //$profile->mentor_working_buyers = $agent[''];
                //$profile->mentor_investing = $agent[''];
                //$profile->lending = $agent[''];
                //$profile->broker2 = $agent[''];                                   

                $profile->save();

                $userPassword->user_id = $user->id;
                $userPassword->save();

                $plain_text = "Welcome. This is invitation to log into the theblacksheephub.com\n You user name is " . $agent['email'] . " and your password is $new_password.\n To log in, visit https://dev.theblacksheephub.com/index.php?r=user%2Fauth%2Flogin."; 

                $html_text = "<p>Welcome. This is invitation to log into the <strong>theblacksheephub.com</strong></p><p>You user name is " . $agent['email'] . "</p><p>and your password is $new_password.</p><p>To log in, visit <a href='https://dev.theblacksheephub.com/index.php?r=user%2Fauth%2Flogin'>dev.theblacksheephub.com</a>.</p>"; 

                Yii::$app->mailer->compose()
                    ->setFrom('admin@theblacksheephub.com')
                    ->setTo('apasho@gmail.com')
                    //->setTo($agent['e mail'])
                    ->setSubject('Welcome to theblacksheephub.com')
                    ->setTextBody($plain_text)
                    ->setHtmlBody($html_text)
                    ->send();            

                foreach($spaces_names as $spaces_name) {  
                  $mSpace = Space::findOne(['name' => $spaces_name]);
                  $mSpace->addMember($user->id);
                }                          
              }
            } else {
              // existing user
              $message = 'updating user ' . $agent['first_name'] . " " . $agent['email'];

              $profile = Profile::findOne(['user_id' => $user->id]);

              if($profile != null) {

                $profile->market = $agent['market'];
                $profile->captain_status = $agent['captain_status'];
                $profile->supervising_broker_status = $agent['supervising_broker_status'];
                $profile->commerical_supervisor_status = $agent['commercial_supervisor_status'];
                $profile->broker = $agent['is_broker'];
                $profile->partner = $agent['is_partner'];

                //$profile->sponsorship_date = $agent[''];
                //$profile->market_other_selection = $agent[''];
                //$profile->license_date = $agent[''];
                //$profile->listing_property_experience = $agent[''];
                //$profile->working_with_buyers_experience = $agent[''];
                //$profile->experience_with_investing = $agent[''];
                //$profile->investment_deals_other_selection = $agent[''];
                //$profile->investment_deals = $agent[''];
                //$profile->funds_available = $agent[''];
                //$profile->language_spoken_other_selection = $agent[''];
                //$profile->language_spoken = $agent[''];
                //$profile->list_property_for_seller = $agent[''];
                //$profile->pay_referral_fees = $agent[''];
                //$profile->work_with_buyers = $agent[''];
                //$profile->wholesaler = $agent[''];
                //$profile->deals_from_wholesalers = $agent[''];
                //$profile->mentor_listing_property = $agent[''];
                //$profile->mentor_working_buyers = $agent[''];
                //$profile->mentor_investing = $agent[''];
                //$profile->lending = $agent[''];
                //$profile->broker2 = $agent[''];                                   

                $profile->save();

              }

            }


          if($counter > 20) 
            break;
        } catch (\Exception $e) {
          Yii::error($e);
        }
      }
    }

    return true;
  }
        
}
