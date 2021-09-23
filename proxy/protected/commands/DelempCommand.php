<?php

class DelempCommand extends CConsoleCommand
{
   
    public function run($args)
    {
    $query="SELECT * FROM employeelist";
      $emp=Yii::app()->sms->createCommand($query)->queryAll();
     
	 if(!empty ($emp))
      {
           foreach ($emp as $data)
          {
		  
		  $id=$data['HREMP_EMPID'];
		  
		  $empsql="SELECT * FROM dbo.EmployeeList WHERE HREMP_EMPID='$id'";
             
		   $previous=Yii::app()->employee->createCommand($empsql)->execute();
		   if(empty ($previous))
		   {
			Yii::app()->sms->createCommand("DELETE FROM employeelist WHERE HREMP_EMPID='$id'")->execute();
			echo "Deleted";
	  
          }
      }
	  echo 'delete employee';
      
}}  }