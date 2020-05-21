<?php
/*
Name: 			Contact Form
Written by: 	Okler Themes - (http://www.okler.net)
Version: 		4.5.1
*/

session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));

header('Content-type: application/json');

// Step 1 - Enter your email address below.
$tocc = 'todd@whiteheadtrust.com';
$to = 'loophole@internode.on.net';
$subject = '62nd Website Enquiry';

// Step 2 - Enable if the server requires SMTP authentication. (true/false)
$enablePHPMailer = true;

//$subject = $_POST['subject'];

if(isset($_POST['email'])) {

	$name = $_POST['name'];
	$email = $_POST['email'];

	$fields = array(
		0 => array(
			'text' => 'Name',
			'val' => $_POST['name']
		),
		1 => array(
			'text' => 'Email address',
			'val' => $_POST['email']
		),
		2 => array(
			'text' => 'Message',
			'val' => $_POST['message']
		)
	);

	$message = "";

	foreach($fields as $field) {
		$message .= $field['text'].": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";
	}

		include("php-mailer/PHPMailerAutoload.php");

		$mail = new PHPMailer;

		$mail->IsSMTP();                                      // Set mailer to use SMTP
		$mail->SMTPDebug = 0;                                 // Debug Mode

		// Step 3 - If you don't receive the email, try to configure the parameters below:

		$mail->Host = 'smtp.sendgrid.net';				  // Specify main and backup server
		$mail->SMTPAuth = true;                             // Enable SMTP authentication
		$mail->Username = 'azure_3dd0de32f379a1885072456e89a90765@azure.com';               // SMTP username
		$mail->Password = '473GF*bG#Alz';                         // SMTP password
		$mail->SMTPSecure = 'tls';                          // Enable encryption, 'ssl' also accepted
		$mail->Port = 587;   								  // TCP port to connect to

		$mail->From = $email;
		$mail->FromName = $_POST['name'];
		$mail->AddAddress($to);								  // Add a recipient
    $mail->AddCC($tocc);								  // Add a cc recipient
		$mail->AddReplyTo($email, $name);

		$mail->IsHTML(true);                                  // Set email format to HTML

		$mail->CharSet = 'UTF-8';

		$mail->Subject = $subject;
		$mail->Body    = $message;

		if(!$mail->Send()) {
		   $arrResult = array ('response'=>'error');
		}

		$arrResult = array ('response'=>'success');

		echo json_encode($arrResult);

} else {

	$arrResult = array ('response'=>'error');
	echo json_encode($arrResult);

}
?>
