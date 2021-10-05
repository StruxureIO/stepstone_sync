<?php 
use yii\helpers\Html;
use yii\helpers\Url;

if($send_emails == 'true')
  $email_checked = 'checked';
else
  $email_checked = '';

if($auto_update == 'true')
  $update_checked = 'checked';
else
  $update_checked = '';

\humhub\modules\stepstone_sync\assets\Assets::register($this);
?>

<div class="container-fluid">
  <div class="panel panel-default">
    <div class="panel-heading"><strong>StepStone Agent Sync</strong></div>

    <div class="panel-body">
      <div id="sync-authorization">
        <p>Sync Authorization</p>
        <div id="alwrap">
          <div id="ajaxloader" style="display:none"></div>
        </div>                  
        <p>
          <label>User Name: </label> <input type="text" id="sync-user-name" class="sync-access-input" value="<?php echo $sync_user_name ?>" >&nbsp;&nbsp;
          <label>Password: </label> <input type="password" id="sync-user-password" class="sync-access-input" value="<?php echo $sync_user_password ?>" >&nbsp;&nbsp;
          <a id="save-sync-credentials" class="btn-primary">Save Settings</a>&nbsp;&nbsp;<span id="save-message"></span>
          <input type="hidden" id="selected-spaces" value="<?php echo $selected_spaces?>">
          <input type="hidden" id="selected-spaces-names" value="<?php echo $selected_spaces_names ?>">
        </p>
                
        <p>
          <label class="switch"><input id="send-emails" type="checkbox" <?php echo $email_checked ?> ><span class="slider round"></span></label><span class="space-label">Send new user emails</span>&nbsp;&nbsp;
          <label class="switch"><input id="auto-update" type="checkbox" <?php echo $update_checked ?> ><span class="slider round"></span></label><span class="space-label">Auto Update</span>                            
        </p>
        <p>Spaces:</p>
        <ul id="space-list">
              <?php
                //$checked = 'checked';
                $selected_spaces = explode(',', $selected_spaces);      
                foreach($spaces as $space) {     
                  //print_r($tag);
                  
                  if(in_array($space['id'], $selected_spaces))
                    $checked = 'checked';      
                  else
                    $checked = '';      
                  
                  echo '<li><label class="switch"><input class="user-space" type="checkbox" '.$checked.' data-id="'.$space['id'].'" data-name="'.$space['name'].'" ><span class="slider round"></span></label><span class="space-label">'.$space['name'].'</span></li>';                  
                }
              ?>  
          
        </ul>

      </div>
      
      <div id="sync-application">
        <p>
          <a id="sync-connect" class="btn-primary">Connect</a>&nbsp;&nbsp;<span id="connected-message"></span>
        </p>
        <p>
          <a id="get-agents" class="btn-primary">Get Agents</a>&nbsp;&nbsp;<span id="agents-message"></span>
        </p>
<!--        <p>
          <a id="add-user" class="btn-primary">Add User</a>&nbsp;&nbsp;<span id="user-message"></span>
        </p>-->
        <p>
          <input type="hidden" id="sync-import-count" value="">
          <a id="process-agents" class="btn-primary">Process Agent Information</a>&nbsp;&nbsp;<span id="process-message"></span>
        </p>
                
        <?php //print_r($spaces) ?>        
        
        
      </div>  

    </div>
  </div>
</div>
<?php
$ajax_credentials = yii\helpers\Url::to(['ajax-credentials']);
$ajax_get_token = yii\helpers\Url::to(['ajax-get-token']);
$ajax_get_agents = yii\helpers\Url::to(['ajax-get-agents']);
$ajax_add_user = yii\helpers\Url::to(['ajax-add-user']);
$ajax_import_count = yii\helpers\Url::to(['ajax-import-count']);
$ajax_get_next_record = yii\helpers\Url::to(['ajax-get-next-record']);
$csrf_param = Yii::$app->request->csrfParam;
$csrf_token = Yii::$app->request->csrfToken;
$this->registerJs("  
  $(document).on('click', '#save-sync-credentials', function (e) {
    e.stopImmediatePropagation();
    
    $('#ajaxloader').show();

    var sync_user_name = $('#sync-user-name').val();        
    var sync_user_password = $('#sync-user-password').val();
    var selected_spaces = $('#selected-spaces').val();
    var selected_spaces_names = $('#selected-spaces-names').val();
    console.log('sync_user_name',sync_user_name);
    
    var send_emails = $('#send-emails').prop('checked');
    
    var auto_update = $('#auto-update').prop('checked');
    
    //console.log('send_emails',send_emails);
                  
    $.ajax({
      'type' : 'GET',
      'url' : '$ajax_credentials',
      'dataType' : 'html',
      'data' : {
        '$ csrf_param' : '$ csrf_token',
        'sync_user_name' : sync_user_name,
        'sync_user_password' : sync_user_password,
        'selected_spaces' : selected_spaces,
        'selected_spaces_names' : selected_spaces_names,
        'send_emails' : send_emails,
        'auto_update' : auto_update
      },
      'success' : function(data){
        $('#ajaxloader').hide();
        $('#save-message').html(data);
      }
    });  
    
  });
  
  $(document).on('click', '#sync-connect', function (e) {
    e.stopImmediatePropagation();
    
    $('#ajaxloader').show();
    
    $.ajax({
      'type' : 'GET',
      'url' : '$ajax_get_token',
      'dataType' : 'html',
      'data' : {
        '$ csrf_param' : '$ csrf_token'
      },
      'success' : function(data){
        $('#ajaxloader').hide();
        $('#connected-message').html(data);
      }
    });  
  
  });
  
  $(document).on('click', '#get-agents', function (e) {
  
    e.stopImmediatePropagation();
    
    $('#ajaxloader').show();
    
    $.ajax({
      'type' : 'GET',
      'url' : '$ajax_get_agents',
      'dataType' : 'html',
      'data' : {
        'filter' : 'all',
        '$ csrf_param' : '$ csrf_token'
      },
      'success' : function(data){
        $('#ajaxloader').hide();
        $('#agents-message').html(data);
      }
    });  
  
  });
  
  $(document).on('click', '.user-space', function () {
    var selected_spaces = '';    
    var selected_spaces_names = '';    

    $('.user-space').each(function() {   
      var space_id = $(this).attr('data-id');      
      var space_name = $(this).attr('data-name');      
      var checked = $(this).is(':checked') 
      if(checked) {
        if(selected_spaces == '') {
          selected_spaces = space_id;
          selected_spaces_names = space_name;
        } else {
          selected_spaces += ',' + space_id;
          selected_spaces_names += ';' + space_name;
        }  
      }        
    });
    $('#selected-spaces').val(selected_spaces);              
    $('#selected-spaces-names').val(selected_spaces_names);              
  });


  $(document).on('click', '#add-user', function (e) {
    e.stopImmediatePropagation();
    $('#ajaxloader').show();
    
    $.ajax({
      'type' : 'GET',
      'url' : '$ajax_add_user',
      'dataType' : 'html',
      'data' : {
        '$ csrf_param' : '$ csrf_token'
      },
      'success' : function(data){
        $('#ajaxloader').hide();
        $('#agents-message').html(data);
      }
    });  
    
  });
  
  $(document).on('click', '#process-agents', function (e) {
  
    console.log('process-agents');
    
    var send_emails = $('#send-emails').prop('checked');
    
    $('#ajaxloader').show();
    
    $.ajax({
      'type' : 'GET',
      'url' : '$ajax_import_count',
      'dataType' : 'html',
      'data' : {
        '$csrf_param' : '$csrf_token'
      },
      'success' : function(data){      
        $('#sync-import-count').val(data);
        $('#process-message').html('record count: ' + data);  
        run_import(0, parseInt(data), send_emails);					
      }
    });  


  });
    
  function get_sync_import_count() {
     console.log('get_sync_import_count');
  
    $.ajax({
      'type' : 'GET',
      'url' : '$ajax_import_count',
      'dataType' : 'html',
      'data' : {
        '$csrf_param' : '$csrf_token'
      },
      'success' : function(data){      
        $('#sync-import-count').val(data);
        $('#process-message').html('record count: ' + data);  
        run_import(0, parseInt(data));					
      }
    });  
  }
  
function run_import(last_record, import_count, send_emails){
  
  $.ajax({
    'type' : 'GET',
    'url' : '$ajax_get_next_record',
    'dataType' : 'json',
    'data' : {
      '$csrf_param' : '$csrf_token',
      'last_record': last_record, 
      'import_count': import_count,
      'send_emails' : send_emails
    },
    'success' : function(data){     
      console.log('data: ', data);
      if(data != null && data.last_record != null) {
        jQuery('#process-message').html(data.message);
        run_import(parseInt(data.last_record), import_count, send_emails);
      } else {
        jQuery('#process-message').html(data.message);
        $('#ajaxloader').hide();
        return false;
      }
    }  
  });  

}

      
");
?>