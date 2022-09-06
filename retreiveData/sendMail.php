
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
use PHPMailer\PHPMailer\PHPMailer; //important, on php files with more php stuff move it to the top
use PHPMailer\PHPMailer\SMTP; //important, on php files with more php stuff move it to the top
date_default_timezone_set('Etc/UTC');

include_once "../vendor/autoload.php"; //important
include_once "../config/config.php";
$data = json_decode(file_get_contents("php://input"));
$userCode=isset($data->userCode)?$data->userCode:"";
$email=$userCode."@nrru.ac.th";
$msg=$data->msg;


$mail = new PHPMailer(true); //important
	$mail->CharSet = 'UTF-8';  //not important
	$mail->isSMTP(); //important
	$mail->Host = 'smtp.office365.com'; //important
	$mail->Port       = 587; //important
	$mail->SMTPSecure = 'tls'; //important
	$mail->SMTPAuth   = true; //important, your IP get banned if not using this
	$mail->IsHTML(true);  

	$mail->Username = 'NRRUBot@nrru.ac.th';
	$mail->Password = 'Nrru2021';

	//Set who the message is to be sent from, you need permission to that email as 'send as'
	$mail->SetFrom('NRRUBot@nrru.ac.th', 'NRRU Individaul Development Plan.'); //you need "send to" permission on that account, if dont use yourname@mail.org

	//Set an alternative reply-to address
	//$mail->addReplyTo($lineNo, 'First Last');

	//Set who the message is to be sent to
	$mail->addAddress($email, 'Participant');
	$mail->Subject = 'Notification for NRRU Individaul Development Plan.';

	$body="<Table>\n";
	$body.="<tr><td>".$msg."</td></tr>";
	$body.="</Table>\n";


	$mail->Body     =  $body;

	if (!$mail->send()) {
		echo json_encode(array("message"=>false,"errInfo"=> $mail->ErrorInfo));
	} else
	{
		echo json_encode(array("message"=>true));
	
	}

?>
