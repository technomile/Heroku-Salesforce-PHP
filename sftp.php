<?php	
	// Include sftp class
	include('Net/SFTP.php');
	
	// Source & destination file Location
	$SourceTextFilePath			= 	UPLOAD_FOLDER_NAME.'/'.REPORT_FILE_NAME.'.txt';
	$DestinationTextFilePath 	=	REPORT_FILE_NAME.'.txt';
		
	// Upload Text File on SFTP
	try {
		$sftp = new Net_SFTP(SFTP_HOSTNAME);
		if (!$sftp->login(SFTP_USERNAME, SFTP_PASSWORD)) {
			exit('Login Failed');
		}
		$sftp->put($DestinationTextFilePath, $SourceTextFilePath, NET_SFTP_LOCAL_FILE);
	}	
	catch (Exception $e) {
		echo $e->getMessage();
	}
?>