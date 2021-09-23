<?php

class DelIsmCommand extends CConsoleCommand
{
   
    public function run($args)
    {
    $query="SELECT * FROM ism_verification";
      $ism=Yii::app()->sms->createCommand($query)->queryAll();
     
	 if(!empty ($ism))
      {
           foreach ($ism as $data)
          {
		  
		  $id=$data['id'];
		  
		  $sql="SELECT * FROM ism_verification WHERE id='$id'";
             
		   $previous=Yii::app()->kebsDb->createCommand($sql)->execute();
		   if(empty ($previous))
		   {
			Yii::app()->sms->createCommand("DELETE FROM ism_verification WHERE id='$id'")->execute();
			echo "Deleted";
	  
          }
      }
      
}}  }