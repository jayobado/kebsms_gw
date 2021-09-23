<?php

class DeldmarkCommand extends CConsoleCommand
{
   
    public function run($args)
    {
    
      $dmark=Yii::app()->sms->createCommand("SELECT * FROM dmark")->queryAll();
      if(!empty ($dmark))
      {
           foreach ($dmark as $data)
          {
		  
		  $id=$data['product_id'];
		  
		  
              /* $firm=addslashes(trim($data['company_name']));
               $brand=addslashes(trim($data['product_brand']));
			   $product=addslashes(trim($data['product_name']));
               $issue_date=$data['issue_date'];
               $expiry_date=$data['expiry_date'];*/
		   
		   $previous=Yii::app()->kebsDb->createCommand("SELECT * FROM dmark WHERE product_id='$id' ")->execute();
		   if(empty ($previous))
		   {
			Yii::app()->sms->createCommand("DELETE FROM dmark WHERE product_id='$id'")->execute();
			echo "Deleted";
	  
          }
      }
      
}}  }