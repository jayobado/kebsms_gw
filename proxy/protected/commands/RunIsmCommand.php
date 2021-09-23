<?php

class RunIsmCommand extends CConsoleCommand
{
   
   public function run($args){

    $ism=Yii::app()->kebsDb->createCommand("SELECT * FROM ism_verification ORDER BY id DESC")->queryAll();

    if(!empty ($ism))
      {
           foreach ($ism as $data)
          {
      
      $id=$data['id'];
      $coc = addslashes(trim($data['COC_Number']));
      $importer = addslashes(trim($data['Importer_Name']));
      $country = addslashes(trim($data['Country_of_origin']));
     $ucr = addslashes(trim($data['UCR_Number']));
       
      // $previous=Yii::app()->smbs_sms->createCommand("SELECT * FROM ism_verification WHERE fortification_id='$id' ")->execute();
             $previous=Yii::app()->sms->createCommand("SELECT * FROM ism_verification WHERE id='$id' ")->execute();

       if(!empty ($previous))
       {
      Yii::app()->sms->createCommand("UPDATE ism_verification SET UCR_Number='$ucr', COC_Number='$coc', Importer_Name='$importer',Country_of_origin='$country' WHERE id='$id'")->execute();
      }
    
              else{
     Yii::app()->sms->createCommand("REPLACE INTO ism_verification(id,Country_of_origin,COC_Number,UCR_Number,Importer_Name)VALUES('$id','$country','$coc','$ucr','$importer') ")->execute();
          }    
          }
      }
          echo "Success!";

   }
}  