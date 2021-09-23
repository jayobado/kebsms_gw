<?php

class OutgoingCommand extends CConsoleCommand
{
   
    public function run($args)
    {
    
      $outgoing=Yii::app()->proxyDb->createCommand("SELECT DISTINCT * FROM outgoing LIMIT 0,999")->queryAll();
       
       if(!empty ($outgoing))
       {
        
           foreach ($outgoing as $res)
           {
               $id=$res['id'];
			   $sender=$res['sender'];
               $receiver=$res['receiver'];
               $message=$res['message'];
			$link_id=$res['link_id'];
			   $currentdate=date('Y-m-d H:i:s');

		
$result=Yii::app()->sdpproxy->createCommand("INSERT INTO outgoing23(code,recipient,message,date,link_id) VALUES('$sender','$receiver','$message','$currentdate','$link_id')")->execute();
              
                 if($result)
                    Yii::app()->proxyDb->createCommand("DELETE FROM outgoing WHERE id=$id")->execute();
           }
       }
          
      
     }}  