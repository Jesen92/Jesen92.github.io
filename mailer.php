<?php
	if($_POST)
	{
		$user_name = $_POST["name"];
		$user_email = $_POST["email"];
		$message = $_POST["message"];

		//reCAPTCHA validation
		if(isset($_POST['g-recaptcha-response'])){
			$captcha=$_POST['g-recaptcha-response'];
			$response= json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LemYa8ZAAAAAP0pNQaeUkMvh7EY8PRl9k52AmBO&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']));

			if ($response->success != true) {
				die(json_encode(array('type'=>'recaptcha error', 'text' => 'invalid recaptcha')));
			}
		}

		$toEmail = "contact@kreativnetehnologije.hr";
		$mailHeaders = "From: " . $user_name . "<" . $user_email . ">\r\n";
		$mailBody = "Ime i prezime: " . $user_name . "\n";
		$mailBody .= "Email: " . $user_email . "\n";
		$mailBody .= "Poruka: " . $message . "\n";
		if (mail($toEmail, "Kreativne Tehnologije - Contact Mail", $mailBody, $mailHeaders)) {
				$output = json_encode(array('type'=>'success'));

				die($output);
		} else {
				$output = json_encode(array('type'=>'error'));

				die($output);
		}
	}
?>
