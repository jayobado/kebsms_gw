<?php

class DelfortCommand extends CConsoleCommand
{
   
    public function run($args)
    {
    
      $fortification=Yii::app()->sms->createCommand("SELECT * FROM fortification")->queryAll();
      if(!empty ($fortification))
      {
           foreach ($fortification as $data)
          {
		  
		  $id=$data['fortification_id'];
		  
		  
              /* $firm=addslashes(trim($data['company_name']));
               $brand=addslashes(trim($data['product_brand']));
			   $product=addslashes(trim($data['product_name']));
               $issue_date=$data['issue_date'];
               $expiry_date=$data['expiry_date'];*/
		   
		   $previous=Yii::app()->kebsDb->createCommand("SELECT * FROM fortification WHERE fortification_id='$id' ")->execute();
		   if(empty ($previous))
		   {
			Yii::app()->sms->createCommand("DELETE FROM fortification WHERE fortification_id='$id'")->execute();
			echo "Deleted";
	  
          }
      }
      
}}  }