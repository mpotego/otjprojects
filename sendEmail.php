<?php
	
if(isset($_POST['email'])) {
 /* echo "Post happened \n\n";	 */
 
 /*Spam - Make like email was sent */
 $isspam = 0;
 
if (isset($_POST['lastName']) && strlen($_POST['lastName']) > 0) {
	$isspam = 1;     
}
    // EDIT THE 2 LINES BELOW AS REQUIRED
    //$email_to = "denism@otjprojects.co.za,mphom@otjprojects.co.za;";
    $email_to = "mpotego@yahoo.com,mpotego@gmail.com";
    $email_subject = "Website Contact Us Form Inquiry";
 
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 
 
    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['message'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');   
		/* return; */
    }
 
     
 
    $first_name = $_POST['name']; // required 
    $email_from = $_POST['email']; // required 
    $comments = $_POST['message']; // required
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered is not valid.<br />';
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$first_name)) {
    $error_message .= 'The First Name you entered is not valid.<br />';
  }
   
  if(strlen($comments) < 2) {
    $error_message .= 'The Comments you entered is not valid.<br />';
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
	
 	/* **** Save email to database */
  /* Example http://php.net/manual/en/pdo.prepared-statements.php*/
	$servername = "localhost";
	$username = "otjproje_DB_User";
	$password = "Pr0j3ct5";
	
try{

  $dsn = 'mysql:host=localhost;dbname=otjproje_main_db';
       
  $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',); 

  $conn = new PDO($dsn, $username, $password, $options);


	if ($stmt = $conn->prepare("CALL prtbContactusemaillog_Save( :param1, :param2, :param3)")) {
        $stmt->bindParam(':param1', $email_from, PDO::PARAM_STR, 100);
        $stmt->bindParam(':param2', $first_name, PDO::PARAM_STR, 100);
	      $stmt->bindParam(':param3', $isspam, PDO::PARAM_INT);   
     
        $stmt->execute(); 
	}	

}
//catch (PDOException $e) {
catch (Exception $e) {
   //echo 'Connection failed: ' . $e->getMessage();
   error_log('DB Connection failed: ' . $e->getMessage(), 0);
   header('location: ContactUsError.html');
   return;
}
	
if($isspam == 1){
  header('location: ContactUsSuccess.html');
	return;
}
		 
 /* *******End Save email to database */
	
 /* Sending the email */     
 
    $email_message .= "First Name: ".clean_string($first_name)."\n"; 
    $email_message .= "Email: ".clean_string($email_from)."\n"; 
    $email_message .= "Comments: ".clean_string($comments)."\n";
 
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion(); 
 
 if (mail($email_to, $email_subject, $email_message, $headers)) {
    header('location: ContactUsSuccess.html');
} else {
    header('location: ContactUsError.html');
}   
/*End of Sending the email */
 
}
?>