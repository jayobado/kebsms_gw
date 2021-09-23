<?php

class Runfort2Command extends CConsoleCommand
{
   
    public function run($args)
    {
    
      $fortification=Yii::app()->sms->createCommand("SELECT * FROM fortification ORDER BY issue_date DESC")->queryAll();
      if(!empty ($fortification))
      {
           foreach ($fortification as $data)
          {
		  
		  $id=$data['fortification_id'];
		  
		  
               $firm=addslashes(trim($data['company_name']));
               $brand=addslashes(trim($data['product_brand']));
			   $product=addslashes(trim($data['product_name']));
               $issue_date=$data['issue_date'];
               $expiry_date=$data['expiry_date'];
		   
		  // $previous=Yii::app()->smbs_sdp->createCommand("SELECT * FROM fortification WHERE fortification_id='$id' ")->execute();
		  		   $previous=Yii::app()->sdp->createCommand("SELECT * FROM fortification WHERE fortification_id='$id' ")->execute();

		   if(!empty ($previous))
		   {
			Yii::app()->sdp->createCommand("UPDATE fortification SET issue_date='$issue_date', expiry_date='$expiry_date',product_name='$product',product_brand='$brand' WHERE fortification_id='$id'")->execute();
			}
	  
              else{
     Yii::app()->sdp->createCommand("REPLACE INTO fortification(fortification_id,product_brand,company_name,product_name,issue_date,expiry_date)VALUES('$id','$brand','$firm','$product','$issue_date','$expiry_date') ")->execute();
          } 
          echo "update_fm";   
          }
      }
      	  echo "Success!";

     }}  