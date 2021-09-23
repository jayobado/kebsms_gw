<?php

class RundmarkCommand extends CConsoleCommand
{
   
    public function run($args)
    {
    
      $dmark=Yii::app()->kebsDb->createCommand("SELECT * FROM dmark ")->queryAll();
      if(!empty ($dmark))
      {
           foreach ($dmark as $data)
          {
		  
		  $id=$data['product_id'];
               
               $firm=addslashes(trim($data['firm_name']));
			   $product=addslashes(trim($data['product']));
               $issue_date=$data['issue_date'];
               $expiry_date=$data['expiry_date'];
		   
		 //  $previous=Yii::app()->smbs_sms->createCommand("SELECT * FROM dmark WHERE firm_id='$id' ")->execute();
		 $previous=Yii::app()->sms->createCommand("SELECT * FROM dmark WHERE product_id='$id' ")->execute();
		   if(!empty ($previous))
		   {
			Yii::app()->sms->createCommand("UPDATE dmark SET issue_date='$issue_date', expiry_date='$expiry_date', firm_name='$firm', product='$product' WHERE product_id='$id'")->execute();
			}
	  
              else{
     Yii::app()->sms->createCommand("REPLACE INTO dmark(product_id,firm_name,product,issue_date,expiry_date)VALUES('$id','$firm','$product','$issue_date','$expiry_date') ")->execute();
          }    
          }
      }
	  echo "Success!";
      
     }}  