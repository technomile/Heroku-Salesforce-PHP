<?php

	####################################################################################################################
	## PROJECT :: PROJECT_NAME																						  ##
	## Functionality :: ACCOUNT_REPORT																				  ##
	## Development Company :: COMPANY_NAME											  							  	  ##	
	####################################################################################################################
	
	require_once ('config.php');	
	
	set_time_limit(0);
	ini_set("soap.wsdl_cache_enabled", "0");
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	
	define("SOAP_CLIENT_BASEDIR", "soapclient");
	require_once (SOAP_CLIENT_BASEDIR.'/SforceEnterpriseClient.php');
	require_once (SOAP_CLIENT_BASEDIR.'/SforceHeaderOptions.php');

	// Set default timezone
	date_default_timezone_set(DEFAULT_TIME_ZONE);
	
	// Create folder if does not exists
	mkdir(UPLOAD_FOLDER_NAME);
	
	// Setting folder permissions
	chmod("/".UPLOAD_FOLDER_NAME, 777);
	
	// Create a log file
	$LogFileName	=	UPLOAD_FOLDER_NAME.'/'.LOG_FILE_NAME.'.txt';
	
	// Create a text file
	$TextFileName = 	UPLOAD_FOLDER_NAME.'/'.REPORT_FILE_NAME.'.txt';

	//Write log and open connection
		$StringData = "\r\n\r\n*************************  BEGINNING OF FILE => ".date("m:d:Y H:i:s")."  *************************\r\n\r\n";				
		$LogFileHandle = fopen($LogFileName, 'a') or die("can't open file");
		fclose($LogFileHandle);
		$fp = fopen($LogFileName, 'a');
		fwrite($fp, $StringData);
		fclose($fp);
	//End Log

	try
	{		
		// Salesforce configurations
		$mySforceConnection	= new SforceEnterpriseClient();
		$mySoapClient = $mySforceConnection->createConnection('soapclient/enterprise.wsdl.xml');
		$mylogin = $mySforceConnection->login(SALESFORCE_USERNAME, SALESFORCE_PASSWORD.SALESFORCE_TOKENKEY);
		
		// Initializing array	
		$TextFields  		=	array();
		$TextFields[0]  	=	'Id'.'|'.'Name'.'|'.'Email';
		
		$i = 1;	
		$queryAccount = "SELECT Id, Name, Email FROM Lead";
		$response_change  = $mySforceConnection->query($queryAccount);
		
		$options = new QueryOptions(50);
		$mySforceConnection->setQueryOptions($options);
		!$done = false;
		if ($response_change->size > 0) {
			while (!$done) {
				foreach ($response_change->records as $record) {
					$TextFields[$i] = $record->Id.'|'.$record->Name.'|'.$record->Email;
					$i++;
				}
				if ($response_change->done != true) {
					try {
						$response_change = $mySforceConnection->queryMore($response_change->queryLocator);
					} catch (Exception $e) {
						print_r($mySforceConnection->getLastRequest());
						echo $e->faultstring;
					}
				} else {
					$done = true;
				}
			}
		}
		
		// Uploading text file	
		$ResultTextFields = implode("\r\n",$TextFields);
		$FileHandle = fopen($TextFileName, 'w') or die("can't open file");
		fclose($FileHandle);
		$fpF = fopen($TextFileName, 'w');
		fputs($fpF, $ResultTextFields);
		fclose($fpF);
			
	} catch (Exception $e) {
		  
		  echo $e->faultstring;
		  echo $mySforceConnection->getLastRequest();
  		  
		  //Write log and close connection
		  $LogFileHandle = fopen($LogFileName, 'a') or die("can't open file");
		  fclose($LogFileHandle);
		  $fp = fopen($LogFileName, 'a');
		  fwrite($fp, $e->faultstring);
		  fclose($fp);		  
 
	}	
	// AUTO FTP STARTS FROM HERE FOR AWS S3	
	require_once ('aws_s3.php');	
	// AUTO SFTP STARTS FROM HERE FOR UQUBE SERVER	
	require_once ('sftp.php');
exit;
?>