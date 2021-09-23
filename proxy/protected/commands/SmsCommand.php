<?php
date_default_timezone_set('Africa/Nairobi');

class SmsCommand extends CConsoleCommand
{
   
    public function run($args)
    {
      	$unstructured=false;
         $unstructuredR = Yii::app()->sms->createCommand(" SELECT * FROM default_responses WHERE  UPPER(response)=UPPER('unstructuredResponse')")->queryRow();
            $unstructuredResponse=$unstructuredR['value'];
      	$noResultsFound=false;
        $noResult = Yii::app()->sms->createCommand(" SELECT * FROM default_responses WHERE UPPER(response)=UPPER('noResult')")->queryRow();
        $noResultResponse=$noResult['value'];
        $noHRFound=false;
        $noHR = Yii::app()->sms->createCommand(" SELECT * FROM default_responses WHERE UPPER(response)=UPPER('noHR')")->queryRow();
      	$noHRResponse=$noHR['value'];
      	$response='';
	$validity='';
                    $status='';
      
 	$inboxes=Yii::app()->sdp->createCommand("SELECT * FROM incoming23 WHERE status=0 ORDER BY id DESC")->queryAll();
      
	foreach ($inboxes as $sms)
      {
          
         	$id=$sms['id'];
		$receiver='20023';
		$string=$sms['phone_no'];
    $sender=substr_replace($string,"254",0,4);
		$query=trim($sms['message']);
		$link_id=$sms['link_id'];
		$currentdatetime=date('Y-m-d H:i:s');
    $currentdate=date('Y-m-d');
  
    $keyword=explode('#',$query);
        
	  $key=$keyword[0];
          
          if(strtoupper($key)=='HR')
          {
              if(!isset ($keyword[1]))
                  $unstructured=true;
              else{
                  
                 $value=$keyword[1];
                 if(is_numeric($value)) {
		 $result=Yii::app()->sms->createCommand("SELECT * FROM employeelist WHERE HREMP_EMPID=$value")->queryRow(); 

                 if(empty ($result))
                 {
                    $noHRFound=true;  
                    $response=$noHRResponse; 
                 }        
                 else
                 {
                  $name=$result['HREMP_NAME'];
                  $status_no=$result['HREMP_STATUS'];
                  $national_id=$result['NationalID'];
                  $job=$result['HRJOB_JOBNAME'];
                  $tday = $result['HREMP_TERMDAY'];
                  $format = "Y-m-d";
                     
                    // $term = date_format($tday, $format);
                     $term = date($format,  strtotime($tday));
                     
                   //  $response='FullName: '.$name.', Position: '.$job;
                     if(!empty($name)) :
                         
                         $response.='Full Name: '.$name;
                     endif;
                     if(!empty($job)) :
                         
                         $response.=',  Position: '.$job;
                     endif;
                     
                     if(!empty($national_id)) :
                         
                         $response.=', National ID: '.$national_id;
                     endif;
	
                     if(!empty($status_no)) {
					 if($status_no==1):
                                             $status='Active';
                                        $response.= ', Status: '.$status.'.';
                                       
					 
					 elseif($status_no==2):
                                             $status='On Leave';
                                         
		$response.= ', Status: '.$status.'.';
                                       				 
					 elseif ($status_no==3):
                  $status='Former Staff';
                  $response.= ', Status: '.$status.',  Former Staff from: '.$term.'.';
                                       
            endif;}
						 
		
                           
                 }
                 
              }
              else { $noHRFound=true;  
                    $response=$noHRResponse;}
                 }
              $send=Yii::app()->sdp->createCommand("INSERT INTO outgoing23(phone_no,code,message,date,link_id) VALUES('$sender','$receiver','$response','$currentdatetime','$link_id')")->execute();
              
                 if($send){
                    Yii::app()->sdp->createCommand("UPDATE incoming23 SET status=1 WHERE id=$id")->execute();				
				}
          }
 else if(strtoupper($key)=='DM')
          {
              if(!isset ($keyword[1]))
                  $unstructured=true;
              else{
                 $value=$keyword[1];

$result=Yii::app()->sms->createCommand("SELECT * FROM dmark WHERE UPPER(product)=UPPER('$value')OR product_id='$value'")->queryRow(); 
                 if(empty ($result))
                 {
                    $noResultsFound=true;  
                    $response=$noResultResponse;
                 }        
                 else
                 {

                     $product=addslashes(trim($result['product']));
                     $firm=addslashes(trim($result['firm_name']));
                     $issue_date=$result['issue_date'];
                     $expiry_date=$result['expiry_date'];
                    
			if($expiry_date >= $currentdate): $validity='Permit is valid';
      else:  $validity='Permit not valid';
      endif;
					 
$response='Product: '.$product.', Firm: '.$firm.', DM Issue Date: '.$issue_date.', Expiry Date: '.$expiry_date.', Status: '.$validity.'.';
                     
                 }
                 
              }
              $send=Yii::app()->sdp->createCommand("INSERT INTO outgoing23(phone_no,code,message,date,link_id) VALUES('$sender','$receiver','$response','$currentdatetime','$link_id')")->execute();
              
                 if($send){
                    Yii::app()->sdp->createCommand("UPDATE incoming23 SET status=1 WHERE id=$id")->execute();				
				}
          }
          else if(strtoupper($key)=='ISM')
          {
            if(!isset ($keyword[1]))
                  $unstructured=true;
              else{
                  
              
                  $value = $keyword[1];
                  $sql = "SELECT * FROM ism_verification WHERE UCR_Number='$value'";
                  $result = Yii::app()->sms->createCommand($sql)->queryRow();

                  if(empty ($result)):
                  	$noResultsFound=true;  
                    $response=$noResultResponse;
                  else:
                  	$coc = addslashes(trim($result['COC_Number']));
                  	$importer = addslashes(trim($result['Importer_Name']));
                  	$country = addslashes(trim($result['Country_of_origin']));
                  	$toll = "Call KEBS Toll Free No. 1545";
                  	$response = "COC Number: ".$coc.", Importer: ".$importer.". ".$toll; 

                  endif;

                  $send=Yii::app()->sdp->createCommand("INSERT INTO outgoing23(phone_no,code,message,date,link_id) VALUES('$sender','$receiver','$response','$currentdatetime','$link_id')")->execute();
              
                 if($send):
                 	Yii::app()->sdp->createCommand("UPDATE incoming23 SET status=1 WHERE id=$id")->execute();
                 endif;
                    
              }
          }

          else if(strtoupper($key)=='SM')
          {
               if(!isset ($keyword[1]))
                  $unstructured=true;
              else{
                 $value=$keyword[1];
				 if(!isset ($keyword[2])){
				 
				 $result=Yii::app()->sms->createCommand("SELECT * FROM firmlisting WHERE UPPER(product_name)=UPPER('$value') OR UPPER(product_brand)=UPPER('$value')OR product_id='$value'")->queryRow(); 
                  
				 if(empty ($result))
                 {
                    $noResultsFound=true;
                    $response=$noResultResponse;
                 }
                 else
                 {
                     $product=addslashes(trim($result['product_name']));
                     $brand=addslashes(trim($result['product_brand']));;
                     $firm=addslashes(trim($result['company_name']));
                     $issue_date=$result['issue_date'];
                     $expiry_date=$result['expiry_date'];

                     if($expiry_date < $currentdate): 
                      $validity='Permit is not valid';
                    else:  
                      $validity='Permit is valid';
                    endif;
						 $response='Product: '.$product.', Brand: '.$brand.', Firm: '.$firm.', SM Issue Date: '.$issue_date.', Expiry Date: '.$expiry_date.', Status: '.$validity.'.';
                    
                 }
                 }
				
              }
              $send=Yii::app()->sdp->createCommand("INSERT INTO outgoing23(phone_no,code,message,date,link_id) VALUES('$sender','$receiver','$response','$currentdatetime','$link_id')")->execute();
              
                 if($send){
                    Yii::app()->sdp->createCommand("UPDATE incoming23 SET status=1 WHERE id=$id")->execute();
			
				}
          }
             else if(strtoupper($key)=='FM')
          {
               if(!isset ($keyword[1]))
                  $unstructured=true;
              else{
                 $value=$keyword[1];
				 if(!isset ($keyword[2])){
				 
	 $result=Yii::app()->sms->createCommand("SELECT * FROM fortification WHERE UPPER(product_name)="
                 . "UPPER('$value') OR UPPER(product_brand)=UPPER('$value')OR  fortification_id='$value'")->queryRow(); 
                  
				
				  
				 if(empty ($result))
                 {
                    $noResultsFound=true;
                    $response=$noResultResponse;
                 }
                 else
                 {
                     $product=addslashes(trim($result['product_name']));
                     $brand=addslashes(trim($result['product_brand']));;
                     $firm=addslashes(trim($result['company_name']));
                     $issue_date=$result['issue_date'];
                     $expiry_date=$result['expiry_date'];

			if($expiry_date >= $currentdate): $validity='Permit is valid';
			else:  $validity='Permit not valid';
      endif;
                     
	$response='Product: '.$product.', Brand: '.$brand.', Firm: '.$firm.', SM Issue Date: '.$issue_date.', Expiry Date: '.$expiry_date.', Status: '.$validity.'.';
                    }
                 }
				
              }
              $send=Yii::app()->sdp->createCommand("INSERT INTO outgoing23(phone_no,code,message,date,link_id) VALUES('$sender','$receiver','$response','$currentdatetime','$link_id')")->execute();
              
                 if($send){
                    Yii::app()->sdp->createCommand("UPDATE incoming23 SET status=1 WHERE id=$id")->execute();
				}
          }
           else if(strtoupper($key)=='CH')
          {
               if(!isset ($keyword[1]))
                  $unstructured=true;
              else{
                 $value=$keyword[1];
				//if(!isset ($keyword[2])){
				 
             $mv=Yii::app()->sms->createCommand("SELECT * FROM mv_db WHERE UPPER(Chassis)=UPPER('$value') OR UPPER(CORNo)=UPPER('$value')OR UPPER(Engine_Number)=UPPER('$value')")->queryRow(); 
                  
				
				  
				 if(empty ($mv))
                 {
                    $noResultsFound=true;
                    $response=$noResultResponse;
                 }
                 else
                 {
                        $cert=addslashes(trim($mv['CORNo']));
                     $make=addslashes(trim($mv['Make']));
                     $model=addslashes(trim($mv['Model']));
                     $chassis=addslashes(trim($mv['Chassis']));
                     $eng_no=addslashes(trim($mv['Engine_Number']));
                     $cc=addslashes(trim($mv['ccRating']));
                     $odometer=addslashes(trim($mv['Odometer_reading']));
                     $country=addslashes(trim($mv['Country']));
                     $ins_date=$mv['Inspection_Date'];
                     $yor=$mv['RegYear'];
                     
                     $response ='CertNo: '.$cert.', Make: '.$make.', Model: '.$model.', ChassisNo: '.$chassis.', EngineNo: '.$eng_no.', CC Rating: '.$cc.'cc, RegYear: '.$yor.', Odometer: '.$odometer.', InspectionDate: '.$ins_date.', Country: '.$country;
            
                 }
             //    }
				
              }
              $send=Yii::app()->sdp->createCommand("INSERT INTO outgoing23(phone_no,code,message,date,link_id) VALUES('$sender','$receiver','$response','$currentdatetime','$link_id')")->execute();
              
                 if($send){
                    Yii::app()->sdp->createCommand("UPDATE incoming23 SET status=1 WHERE id=$id")->execute();
				
				}
          }
          else{
             $key=strtoupper($key);
            
          
             $result=Yii::app()->sms->createCommand("SELECT * FROM keywords WHERE UPPER(keyword)='$key'")->queryRow(); 
             if(empty ($result))

             {
                $unstructured=true;  
                $response=$unstructuredResponse;
             }
              else{
             $response=addslashes(trim($result['response']));}
             
              
              $send=Yii::app()->sdp->createCommand("INSERT INTO outgoing23(phone_no,code,message,date,link_id) VALUES('$sender','$receiver','$response','$currentdatetime','$link_id')")->execute();
              
                 if($send){
                    Yii::app()->sdp->createCommand("UPDATE incoming23 SET status=1 WHERE id=$id")->execute();			
				}
          }
       }
     
					
        
      
      echo 'test';
    }

public function post_to_url($url)
	{

		$curl_connection = curl_init($url);
 

		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
 

		//curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
		$post = curl_exec($curl_connection);
		curl_close($curl_connection);
		if($post === false){ echo "Error Number:".curl_errno($ch)."<br>"; echo "Error String:".curl_error($ch);}
	}
}
