<?php
// Salesforce Access Details
define("SALESFORCE_USERNAME","");
define("SALESFORCE_PASSWORD","");
define("SALESFORCE_TOKENKEY","");

// AWS S3 Access Details
define("AWS_S3_ACCESS_KEY","");
define("AWS_S3_SECRETE_KEY","");
define("AWS_S3_BUCKET_NAME","");
define("AWS_S3_SITE_URL","http://".AWS_S3_BUCKET_NAME.".s3.amazonaws.com/");

// SFTP Access Details
define("SFTP_HOSTNAME","");
define("SFTP_USERNAME","");
define("SFTP_PASSWORD","");

// Other Details
define("UPLOAD_FOLDER_NAME",""); // uploads
define("LOG_FILE_NAME",""."_".date("mdYHis")); // LOG_LEAD_REPORT
define("REPORT_FILE_NAME",""."_".date("mdYHis")); // LEAD_REPORT
define("DEFAULT_TIME_ZONE",""); // America/New_York
?>