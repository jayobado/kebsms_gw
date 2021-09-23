<?php

class RunEmpCommand extends CConsoleCommand
{
   
    public function run($args)
    {
      
	$query="SELECT * FROM KEBSPSA.dbo.EmployeeList";
	 // $query="";
      $employee=Yii::app()->employee->createCommand($query)->queryAll();
	  $today = date('Y_m_d');
	  $now = date('His');
		//$myfile = fopen("C:\Documents and Settings\kebsadmin\Desktop\emp_logs_".$today."_".$now.".txt", "w") or die("Unable to open file!");
	  if(!empty ($employee))
      {
      
	  foreach ($employee as $emp)
      {
          $name=trim($emp['HREMP_NAME']);
          $status_no=$emp['HREMP_STATUS'];
           $nid=$emp['NationalID'];
           $job=$emp['HRJOB_JOBNAME'];
			$emp_id=$emp['HREMP_EMPID'];
			$emp_type=$emp['HREMP_EMPTYPE'];
			$term_day=$emp['HREMP_TERMDAY'];
         
		 $psql="SELECT * FROM employeelist WHERE HREMP_EMPID='$emp_id' ";
		 		$previous=Yii::app()->sms->createCommand($psql)->execute();

	
		   if(!empty ($previous)){
			   		 
		$upsql="UPDATE employeelist SET HREMP_STATUS='$status_no',HRJOB_JOBNAME='$job',HREMP_NAME='$name',
		HREMP_EMPTYPE='$emp_type',HREMP_TERMDAY='$term_day' WHERE HREMP_EMPID='$emp_id'";
		//$txt = $name.",EmpID=".$emp_id.", Status=".$status_no."\n";
		//fwrite($myfile, $txt);

			   Yii::app()->sms->createCommand($upsql)->execute(); 
			  // echo 'update';
			   }		 
			else{
						 $insql="INSERT INTO employeelist (HREMP_EMPID,HREMP_NAME,NationalID,HRJOB_JOBNAME,
						 HREMP_EMPTYPE,HREMP_STATUS,HREMP_TERMDAY) VALUES('$emp_id','$name','$nid','$job','$emp_type','$status_no','$term_day')";

						Yii::app()->sms->createCommand($insql)->execute();
					//	echo 'insert';

			}		 
				 	
         
      }}
      echo 'update employee';
	 // fclose($myfile);
    }
}
