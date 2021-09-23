<?php

class RunMotorCommand extends CConsoleCommand
{
   
    public function run($args)
    {
      
	$query="SELECT * FROM MotorVehicle.dbo.vw_QISJ";
	 // $query="";
      $motor=Yii::app()->motor->createCommand($query)->queryAll(); 
	  if(!empty ($motor))
      {
      
	  foreach ($motor as $moto)
      {
          $cor_no=trim($moto['CORNo']);
          $doi=$moto['DateofIssue'];
           $country=$moto['CountryofSupply'];
           $inpsect=$moto['InspectionCenter'];
			$app_date=$moto['ApplicationBookingDate'];
			$inspect_date=$moto['InspectionDate'];
		 $make=$moto['Make'];
         $model=$moto['Model'];
         $chassis=$moto['ChassisVINNumber'];
         $engine=$moto['EngineNumberModel'];
         $capacity=$moto['EngineCapacity'];
         $manufacture=$moto['YearofManufacture'];
         $registration=$moto['YearofFirstRegistration'];
         $mileage=$moto['InspectedMileage'];
         $remarks=$moto['Remarks'];
         
		 $psql="SELECT * FROM mv_db WHERE COR_NO='$cor_no' ";
		 
		 $upsql="UPDATE mv_db SET DATE_OF_ISSUE='$doi',COUNTRY='$country',INSPECTION_CENTER='$inspect',APPLICATION_DATE='$app_date',INSPECTION_DATE='$inspect_date',
		 MAKE='$make',MODEL='$model',CHASSIS='$chassis',ENGINE_NUMBER='$engine',CC_RATING='$capacity',YEAR_OF_MANU='$manufacture',REGISTRATION_YEAR='$registration',
		 ODOMETER_READING='$mileage' WHERE COR_NO='$cor_no'";
		 
		 $insql="INSERT INTO mv_db (COR_NO,DATE_OF_ISSUE,COUNTRY,INSPECTION_CENTER,APPLICATION_DATE,INSPECTION_DATE, MAKE,MODEL,CHASSIS,ENGINE_NUMBER,
		 CC_RATING,YEAR_OF_MANU,REGISTRATION_YEAR,ODOMETER_READING)  
		 VALUES('$cor_no','$doi','$country','$inpsect','$app_date','$inspect_date','$make','$model','$chassis','$engine','$capacity',
		 '$manufacture','$registration','$mileage')";
		 
		 
		 //$previous=Yii::app()->moto_sms->createCommand($psql)->execute();
		 		 $previous=Yii::app()->sms->createCommand($psql)->execute();

		   if(!empty($previous)){Yii::app()->sms->createCommand($upsql)->execute(); }		 
			else{
						Yii::app()->sms->createCommand($insql)->execute();

			}		 
				 	
         
      }}
      echo 'update motor';
    }
}
