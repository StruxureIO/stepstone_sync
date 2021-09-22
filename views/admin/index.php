<?php 
use yii\helpers\Html;
use yii\helpers\Url;

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
          <a id="save-sync-credentials" class="btn-primary">Save</a>&nbsp;&nbsp;<span id="save-message"></span>
          <input type="hidden" id="selected-spaces" value="<?php echo $selected_spaces?>">
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
                  
                  echo '<li><label class="switch"><input class="user-space" type="checkbox" '.$checked.' data-id="'.$space['id'].'" ><span class="slider round"></span></label><span class="space-label">'.$space['name'].'</span></li>';                  
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
    console.log('sync_user_name',sync_user_name);
                  
    $.ajax({
      'type' : 'GET',
      'url' : '$ajax_credentials',
      'dataType' : 'html',
      'data' : {
        '$ csrf_param' : '$ csrf_token',
        'sync_user_name' : sync_user_name,
        'sync_user_password' : sync_user_password,
        'selected_spaces' : selected_spaces
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

    $('.user-space').each(function() {   
      var space_id = $(this).attr('data-id');      
      var checked = $(this).is(':checked') 
      if(checked) {
        if(selected_spaces == '') 
          selected_spaces = space_id;
        else
          selected_spaces += ',' + space_id;
      }        
    });
    $('#selected-spaces').val(selected_spaces);              
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
        run_import(0, parseInt(data));					
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
  
function run_import(last_record, import_count){
  
  $.ajax({
    'type' : 'GET',
    'url' : '$ajax_get_next_record',
    'dataType' : 'json',
    'data' : {
      '$csrf_param' : '$csrf_token',
      'last_record': last_record, 
      'import_count': import_count
    },
    'success' : function(data){     
      console.log('data: ', data);
      if(data != null && data.last_record != null) {
        jQuery('#process-message').html(data.message);
        run_import(parseInt(data.last_record), import_count);
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