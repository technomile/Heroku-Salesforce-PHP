<?php
	// Include the S3 class
	if (!class_exists('S3'))require_once('S3.php');
						
	// Instantiate the class
	$s3 = new S3(AWS_S3_ACCESS_KEY, AWS_S3_SECRETE_KEY);
	
	// Source & destination file Location
	$SourceTextFilePath			= 	UPLOAD_FOLDER_NAME.'/'.REPORT_FILE_NAME.'.txt';
	$DestinationTextFilePath 	=	REPORT_FILE_NAME.'.txt';

	// Upload Text File on AWS S3
	try {
		if ($s3->putObjectFile($SourceTextFilePath, AWS_S3_BUCKET_NAME, $DestinationTextFilePath, S3::ACL_PUBLIC_READ)) {
			echo "<BR/><strong>Your text file has been uploaded successfully.</strong><BR/>";
		}else{
			echo "<BR/><strong>Something went wrong while uploading text file.</strong><BR/>";
		}
	}catch (Exception $e) {
		echo $e->getMessage();
	}	
?>