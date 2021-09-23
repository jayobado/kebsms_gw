<?php

class DelMotCommand extends CConsoleCommand
{
   
    public function run($args)
    {
    $query="SELECT * FROM mv_db";
      $moto=Yii::app()->sms->createCommand($query)->queryAll();
     
	 if(!empty ($moto))
      {
           foreach ($moto as $data)
          {
		  
		  $id=$data['COR_NO'];
		  
		  $motosql="SELECT * FROM dbo.QISJ WHERE CORNo='$id'";
             
		   $previous=Yii::app()->motor->createCommand($motosql)->execute();
		   if(empty ($previous))
		   {
			Yii::app()->sms->createCommand("DELETE FROM mv_db WHERE COR_NO='$id'")->execute();
			echo "Deleted";
	  
          }
      }
      
}}  }