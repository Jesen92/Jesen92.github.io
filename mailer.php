<?php
	if($_POST)
	{
		$user_name = $_POST["name"];
		$user_email = $_POST["email"];
		$message = $_POST["message"];
		$subject = $_POST["subject"];

		//reCAPTCHA validation
		if(isset($_POST['g-recaptcha-response'])){
			$captcha=$_POST['g-recaptcha-response'];
			$response= json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Ld0gNsZAAAAAGkGxJ-JbJZAFS-aKWlFceH9jjNo&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']));

			if ($response->success != true) {
				die(json_encode(array('type'=>'recaptcha error', 'text' => 'invalid recaptcha')));
			}
		}

		$toEmail = "contact@rimorplus.com";
		$mailHeaders = "From: " . $user_name . "<" . $user_email . ">\r\n";
		$mailBody = "Subject: " . $subject . "\n";
		$mailBody = "Ime i prezime: " . $user_name . "\n";
		$mailBody .= "Email: " . $user_email . "\n";
		$mailBody .= "Poruka: " . $message . "\n";
		if (mail($toEmail, $subject, $mailBody, $mailHeaders)) {
				$output = json_encode(array('type'=>'success'));

				die($output);
		} else {
				$output = json_encode(array('type'=>'error'));

				die($output);
		}
	}
?>
