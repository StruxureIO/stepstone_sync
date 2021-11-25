<?php

namespace humhub\modules\stepstone_sync\controllers;

use humhub\modules\admin\components\Controller;
use humhub\modules\user\models\User;
use humhub\modules\user\models\GroupUser;
use humhub\modules\user\models\Password;
use humhub\modules\user\models\Profile;
use humhub\modules\space\models\Space;
use humhub\modules\stepstone_sync\models\Import;
use humhub\modules\stepstone_sync\helpers\SyncHelper;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Query;

class AdminController extends Controller
{
  
    public $mSpaces;
    public $mImport;

    /**
     * Render admin only page
     *
     * @return string
     */
    public function actionIndex() {
      
      $sync_user_name = Yii::$app->getModule('stepstone_sync')->settings->get('user');
      
      $sync_user_password = Yii::$app->getModule('stepstone_sync')->settings->get('password');
      
      $selected_spaces = Yii::$app->getModule('stepstone_sync')->settings->get('selected-spaces');   
      
      $selected_spaces_names = Yii::$app->getModule('stepstone_sync')->settings->get('selected-spaces-names');    
            
      $send_emails = Yii::$app->getModule('stepstone_sync')->settings->get('send-emails');          
      
      $auto_update = Yii::$app->getModule('stepstone_sync')->settings->get('auto-update');          
                                  
      $spaces = (new \yii\db\Query())
          ->select(['id', 'name'])
          ->from('space')
          ->all();      
      
      return $this->render('index', [
        'sync_user_name' => $sync_user_name, 
        'sync_user_password' => $sync_user_password,
        'selected_spaces' => $selected_spaces,
        'selected_spaces_names' => $selected_spaces_names,  
        'send_emails' => $send_emails,
        'auto_update' => $auto_update,
        'spaces' => $spaces  
      ]);
    }
    
    public function actionAjaxCredentials($sync_user_name, $sync_user_password, $selected_spaces, $selected_spaces_names, $send_emails, $auto_update) {
      
      Yii::$app->getModule('stepstone_sync')->settings->set('user', $sync_user_name);
      
      Yii::$app->getModule('stepstone_sync')->settings->set('password', $sync_user_password);
      
      Yii::$app->getModule('stepstone_sync')->settings->set('selected-spaces', $selected_spaces);    
      
      Yii::$app->getModule('stepstone_sync')->settings->set('selected-spaces-names', $selected_spaces_names);          
      
      Yii::$app->getModule('stepstone_sync')->settings->set('send-emails', $send_emails);    
      
      Yii::$app->getModule('stepstone_sync')->settings->set('auto-update', $auto_update);    
            
      echo "The settings were saved.";
      
      die();
      
    }
    
    public function actionAjaxGetToken() {
      
      $sync_user_name = Yii::$app->getModule('stepstone_sync')->settings->get('user');
      
      $sync_user_password = Yii::$app->getModule('stepstone_sync')->settings->get('password');
      
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.stepstoneadmin.com/user-auth',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"email": "'.$sync_user_name.'", "password": "'.$sync_user_password.'" }',  
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json',
          'Accept: application/json'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      $json_response = json_decode($response, true);
      //print_r($json_response['data']['data']['token']);
      if(isset($json_response['data']['data']['token'])) {
        Yii::$app->getModule('stepstone_sync')->settings->set('token', $json_response['data']['data']['token']);
        echo "Connected.";
      } else {
        echo "Not connected.";        
      }            
      
      die();
            
    }
            
    public function actionAjaxGetAgents($filter) {
      
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
      $html .= "<p>Done saving agent info.</p>";        

      

      curl_close($curl);
      echo $html;
      
      die();
      
    }
    
    public function actionAjaxAddUser() {
      
      $selected_spaces = Yii::$app->getModule('stepstone_sync')->settings->get('selected-spaces');    
      
      $spaces = (new \yii\db\Query())
          ->select(['id', 'name'])
          ->from('space')
          ->all();      
      
      $new_password = SyncHelper::generate_password();
      
      $data = array();
      $data['username'] = 'testuser5';
      $data['email'] = 'test5@mail.com';
      $data['firstname'] = 'Linkcon';
      $data['lastname'] = 'Smith';
      
      $userModel = new User();
      $userModel->scenario = 'registration';

      $profileModel = $userModel->profile;
      $profileModel->scenario = 'registration';

      $userModel->username = $data['username'];
      $userModel->email = $data['email'];
      
      $userModel->status = User::STATUS_ENABLED;

      $profileModel->firstname = $data['firstname'];
      $profileModel->lastname = $data['lastname'];
		
      $userPasswordModel = new Password();
      $userPasswordModel->setPassword($new_password);

      if($userModel->save()) { 
        
        $profileModel->user_id = $userModel->id;
        $profileModel->market = 'Dallas';
        $profileModel->save();

        $userPasswordModel->user_id = $userModel->id;
        $userPasswordModel->save();
        
        $selected_spaces = explode(',', $selected_spaces);      
        foreach($spaces as $space) {     

          if(in_array($space['id'], $selected_spaces)) {                
            $mSpace = Space::findOne(['name' => $space['name']]);
            $mSpace->addMember($userModel->id);
          }  
        }                          
      }
      
      echo "new password " . $new_password;
      
      die();
        
    }
        
    public function actionAjaxImportCount() {
      
      $connection = Yii::$app->getDb();

      $command = $connection->createCommand("select count(id) from import");

      $count = $command->queryOne();      
      
      echo $count['count(id)'];
      
      die();      
      
    }
    
    public function actionAjaxGetNextRecord($last_record, $import_count) {
      
      // get selected spaces to add new users
      $selected_spaces_names = Yii::$app->getModule('stepstone_sync')->settings->get('selected-spaces-names');    
      $spaces_names = explode(';', $selected_spaces_names);            
      
      $send_emails = Yii::$app->getModule('stepstone_sync')->settings->get('send-emails');          
                  
      $message = '';
            
      $last_record = intval($last_record);
      
      $import_count = intval($import_count);
      
      if($import_count != 0)
		    $percentage = ceil((($last_record+1) / $import_count) * 100);
      else
        $percentage = 0;
            
      $connection = Yii::$app->getDb();      
              
      $command = $connection->createCommand("select * from import order by id limit $last_record, 1");
      
      $row = $command->queryAll();   
      									
			if($row) {		
        
        $agent = json_decode($row[0]['data'],  true);        
                
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
                        
            // availale fields with no corresponding data
            
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
            
            $plain_text = "Welcome. This is invitation to log into the theblacksheephub.com\n You user name is " . $agent['email'] . " and your password is $new_password.\n To log in, visit https://theblacksheephub.com/user/auth/login."; 
            
            // for production, change to the proper web site URL
            $html_text = "<p>Welcome. This is invitation to log into the <strong>theblacksheephub.com</strong></p><p>You user name is " . $agent['email'] . "</p><p>and your password is $new_password.</p><p>To log in, visit <a href='https://theblacksheephub.com/user/auth/login'>theblacksheephub.com</a>.</p>"; 
            
            // uncomment for production 
            if($send_emails == 'true') {
              Yii::$app->mailer->compose()
                  ->setFrom('admin@theblacksheephub.com')
                  ->setTo($agent['email'])
                  ->setSubject('Welcome to theblacksheephub.com')
                  ->setTextBody($plain_text)
                  ->setHtmlBody($html_text)
                  ->send();  
            }

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
            
            // availale fields with no corresponding data            
                        
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
              
				$last_record++;
        
        // remove these three lines to use in production
        if($last_record > 3)
				  $data = array('message' => 'Import complete.', 'last_record' => null, 'percentage' => 100 );								
				else
				  $data = array('message' => $message, 'last_record' => $last_record, 'percentage' => $percentage );				
			} else {
				$data = array('message' => 'Import complete.', 'last_record' => null, 'percentage' => 100 );								
			}		
      
      echo json_encode($data);
      
      die();
            
    }
    

}

