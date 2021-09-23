<?php

class Runsmark2Command extends CConsoleCommand
{
   
    public function run($args)
    {
    
      $firmlisting=Yii::app()->sms->createCommand("SELECT * FROM firmlisting ORDER BY issue_date DESC")->queryAll();
      if(!empty ($firmlisting))
      {
           foreach ($firmlisting as $data)
          {
		  
		  $id=$data['product_id'];
		  $firm=addslashes(trim($data['company_name']));
          $brand=addslashes(trim($data['product_brand']));
		  $product=addslashes(trim($data['product_name']));
          $issue_date=$data['issue_date'];
          $expiry_date=$data['expiry_date'];
		  
		  $select = "SELECT * FROM firmlisting WHERE product_id='$id'";
		   
		  // $previous=Yii::app()->smbs_sdp->createCommand("SELECT * FROM firmlisting WHERE product_id='$id' ")->execute();
		  $previous=Yii::app()->sdp->createCommand($select)->execute();
		  
		  $update = "UPDATE firmlisting SET issue_date='$issue_date', expiry_date='$expiry_date', product_name='$product', product_brand='$brand',
					company_name='$firm' WHERE product_id='$id'";
					
		  $insert = "INSERT INTO firmlisting (product_id,product_brand,company_name,product_name,issue_date,expiry_date) 
						VALUES('$id','$brand','$firm','$product','$issue_date','$expiry_date')"; 

		   if(!empty ($previous))
		   {
			Yii::app()->sdp->createCommand($update)->execute();
			echo "update_sm";
			}
	  
              else{
				Yii::app()->sdp->createCommand($insert)->execute();
				echo "insert";
          }    
          }
      }
      	  echo "Success!";

     }}  