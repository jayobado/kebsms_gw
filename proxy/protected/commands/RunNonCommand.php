<?php

class RunNonCommand extends CConsoleCommand
{
   
    public function run($args)
    {
    
    
      
	  $non=Yii::app()->ism->createCommand("SELECT * FROM dbo.View_SMS_Non_Licensed")->queryAll();
      if(!empty ($non))
      {
           foreach ($non as $data)
          {
			    $man=addslashes(trim($data['MANUFACTURERNAME_EN']));
                  $prod=addslashes(trim($data['PRODUCTNAME']));
                  $brand=addslashes(trim($data['PRODUCT_BRAND']));
                  $orig=addslashes(trim($data['INDENT_ORIGIN']));
				  $usdn=addslashes(trim($data['USDN_NO_ENCRYPT']));
		 
		   
		   $previous=Yii::app()->ism_proxy->createCommand("SELECT * FROM View_SMS_Non_Licensed WHERE USDN_NO_ENCRYPT='$usdn' ")->execute();
		   if(!empty ($previous))
		   {
			//Yii::app()->ism_proxy->createCommand("UPDATE ism SET issue_date='$issue_date', expiry_date='$expiry_date' WHERE product_id='$id'")->execute();
			}
	  
              else{
     Yii::app()->ism_proxy->createCommand("REPLACE INTO View_SMS_Non_Licensed (MANUFACTURERNAME_EN,PRODUCT_BRAND,PRODUCTNAME,INDENT_ORIGIN,USDN_NO_ENCRYPT)VALUES('$man','$brand','$prod','$orig','$usdn') ")->execute();
          }    
          }
      }
	  
     }}  