StepStone Sync 
 
The StepStone Sync module is available in the Admin menu under the site administration. The 
sync module connects with the api.stepstoneadmin.com site to retrieve StepStone member 
data to add or updated agent records in the theblacksheephub.com site. 
 
To use, visit the  StepStone Sync page and enter admin login credentials in the Sync 
Authorization. Also select whether to send an email to new agents, turn on or off the Auto 
Update option which will run when the daily cron job takes place and select which spaces that 
new users will be added to. Click the Save Settings to save all these options. 
 
To begin the sync process, after entering and saving the settings mentioned above, click the 
Connect button to authorize access to the stepstoneadmin.com data. The result of this action 
will be display next to the button, either Connected or Not connected.  
 
Once connected, click the Get Agents button. All the allowed data for all agents is transmitted 
to the theblacksheephub.com and stored in a temporary table.  Rather than processing all the 
information at one time, which could lead to a max execution time error by the server, the data 
is stored locally so each agent's data can be process one record at a time without any server 
errors. Once the agent data has been received, the message, 'Done saving agent info.' will be 
displayed next to the Get Agents button.  
 
Finally, clicking the Process Agent Information button will read each record stored in the 
temporary table, add or update the agent's information in the theblacksheephub.com site. 
While processing the agents, a status message will appear next to the Process Agent button 
showing the name of the agent being processed and the percentage of the total records 
processed. 
 
For agents not currently registered on theblacksheephub.com, new user and profile records will 
be created and an account password will be generated. Each agent will be added to the 
currently selected spaces. 
 
Currently, the data from api.stepstoneadmin.com that is stored on theblacksheephub.com 
includes 
 
Agent's email 

First name 

Last name 

Phone number 

Market 

Captain status 

Supervising broker status 

Commercial supervisor status 

Is broker 

Is partner 
 
The invitation email that is sent to new users is as follows: 
 
Welcome. This is invitation to log into the theblacksheephub.com  
You user name is [user email address] and your password is [new password]. 
To log in, visit https://theblacksheephub.com/user/auth/login 
 
This modify this text, edit the 
protected/modules/stepstone_sync/controllers/AdminController.php file. The text is located in 
the actionAjaxGetNextRecord() function around line 350. 
 
For testing purposes, the function for importing agent records has been limited to three agents. 
To remove the limitation, comment out the following three lines near line 419 in 
AdminController.php file: 
 
if($last_record > 3) 
  $data = array('message' => 'Import complete.', 'last_record' => null, 'percentage' => 100 );
else 
