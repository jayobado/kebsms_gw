<?php

class DelsmarkCommand extends CConsoleCommand
{
   
    public function run($args)
    {
    
      $firmlisting=Yii::app()->sms->createCommand("SELECT * FROM firmlisting")->queryAll();
      if(!empty ($firmlisting))
      {
           foreach ($firmlisting as $data)
          {
		  
		  $id=$data['product_id'];
		  
		  
              /* $firm=addslashes(trim($data['company_name']));
               $brand=addslashes(trim($data['product_brand']));
			   $product=addslashes(trim($data['product_name']));
               $issue_date=$data['issue_date'];
               $expiry_date=$data['expiry_date'];*/
		   
		   $previous=Yii::app()->kebsDb->createCommand("SELECT * FROM firmlisting WHERE product_id='$id' ")->execute();
		   if(empty ($previous))
		   {
			Yii::app()->sms->createCommand("DELETE FROM firmlisting WHERE product_id='$id'")->execute();
			echo "Deleted";
	  
          }
      }
      
}}  }