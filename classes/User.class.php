<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

class User
{
	public static function loggedIn()
	{
		if (isset($_COOKIE['hrm-user']) && $_COOKIE['hrm-user'] != "") {
			return true;
		}
		return false;
	}

	public static function login($email, $password, $status)
	{
		$query = Db::fetch("users", "token, password, email", "email = ? AND status = ?  ", array($email, $status), "", "", "");

		if (Db::count($query)) {
			$userData = Db::assoc($query);
			$hashedPassword = $userData['password'];

			if (password_verify($password, $hashedPassword)) {
				Messages::success("Login Succeeded");
				$token = $userData['token'];
				$emailAddress = $userData['email'];

				// Generate a 6-digit OTP
				$otp = rand(100000, 999999);

				// Update the OTP in the database
				Db::update("users", array("otp"), array($otp), "token = ? ", $token);

				// Send the OTP to the user's email
				$subject = "Verification code";
				$message = "Please use the code $otp to verify your account and proceed to your dashboard!";
				self::sendVerificationCode($emailAddress, $subject, $message);

				// Set the user token in the cookie for security purposes
				setcookie("hrm-user", $token, time() + (60 * 60 * 24 * 7 * 30), "/", "", "", TRUE);

				Config::redir("otp_verification.php");
				return;
			}
		}

		// If the email or password is incorrect
		if ($status == 1) {
			$userType = "Employee";
		} else {
			$userType = "Admin";
		}

		Messages::error("Either your email or password is incorrect. <strong>WAIT</strong>, did you mean to login as $userType? Please click <strong><a href='login.php'>HERE</a></strong> to log in as $userType");
	}

	// Add a helper function to send the verification code via email
	private static function sendVerificationCode($emailAddress, $subject, $message)
	{
		// Create a new PHPMailer instance
		$mail = new PHPMailer(true); // Set true to enable exceptions

		try {
			// Server settings
			$mail->SMTPDebug = 0; // 0 = no output, 2 = verbose output
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com'; // Your SMTP server
			$mail->Port = 587; // Your SMTP server port
			$mail->SMTPAuth = true;
			$mail->Username = 'ketergilbert759@gmail.com'; // Your SMTP username
			$mail->Password = 'tjtw etwf kdwu arnx'; // Your SMTP password
			$mail->SMTPSecure = 'tls'; // tls or ssl

			// Recipients
			$mail->setFrom('ketergilbert759@gmail.com', 'HRM '); // Sender email and name
			$mail->addAddress($emailAddress); // Recipient email

			// Content
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body = $message;
			$mail->send();
			$error = "Verification code sent to $emailAddress. Please check your email.";
		} catch (Exception $e) {
			echo "Error sending reset link: {$mail->ErrorInfo}";
		}
	}



	public static function get($token, $field)
	{
		$query = Db::fetch("users", "$field", "token = ? ", $token, "", "", "");
		$data = Db::num($query);
		return $data[0];
	}

	public static function getbyid($eid, $field)
	{
		$query = Db::fetch("users", "$field", "id = ? ", $eid, "", "", "");
		$data = Db::num($query);
		return $data[0];
	}

	public static function getToken()
	{
		if (self::loggedIn()) {
			return $_COOKIE['hrm-user'];
		}
		return "";
	}


	public static function profile($token)
	{
		$pic = User::get($token, "profile");
		$img = (!empty($pic)) ? ($pic) : ("profile.png");
		$empid = User::get($token, "id");
		$userFirstName = User::get($token, "firstName");
		$userSecondName = User::get($token, "secondName");
		$userEmail = User::get($token, "email");
		$userPassword = User::get($token, "password");
		$userToken = User::get($token, "token");
		$userStatus = User::get($token, "status");
		$userPhone = User::get($token, "phone");
		$userProfile = User::get($token, "profile");
		$userGender = User::get($token, "gender");
		$userRole = User::get($token, "designation");

		if ($userStatus == 1) {
			$userRole = "Admin";
			$userSalary = "Admin";
		} else {
			$userRole = $userRole;
		}
		echo "<div class='form-holder'>";

		$form = new Form(3, "post");
		$form->init();
		echo "
			<div class='form-group'>
				<label class='col-md-3'>Photo</label>
				<div class='col-md-9'>
					<img src='images/$img' width='70px' height='70px'> 
				</div> 
			</div> 
		";
		$form->textBox("Employee Id", "user-ei", "text",  $empid, array("readonly='readonly'", "  style='font-size: 17px;' "));
		$form->textBox("First Name", "user-fn", "text",  $userFirstName, array("readonly='readonly'", "  style='font-size: 17px;' "));
		$form->textBox("Last Name", "user-sn", "text",  $userSecondName, array("readonly='readonly'", "  style='font-size: 17px;' "));
		$form->textBox("Email", "user-em", "text",  $userEmail, array("readonly='readonly'", "  style='font-size: 17px;' "));
		$form->textBox("Designation", "user-role", "text",  $userRole, array("readonly='readonly'", "  style='font-size: 17px;' "));
		$form->textBox("Gender", "user-gender", "text",  $userGender, array("readonly='readonly'", "  style='font-size: 17px;' "));
		$form->textBox("Phone", "user-phone", "text",  $userPhone, array("readonly='readonly'", "  style='font-size: 17px;' "));
		$form->close("");

		echo "</div>";
	}

	// public static function changePassword($oldPassword, $newPassword)
	// {
	// 	if (!self::loggedIn()) {
	// 		Messages::error("Login first!");
	// 		return;
	// 	}
	// 	$query = Db::fetch("users", "password", "token = ? ", self::getToken(), "", "", "");
	// 	$dataCurrentPassword = Db::num($query);
	// 	$currentPassword = $dataCurrentPassword[0];
	// 	if ($currentPassword != $oldPassword) {
	// 		Messages::error("Your old password could not be found in the system");
	// 		return;
	// 	}
	// 	Db::update("users", array("password"), array($newPassword), "token = ? ", self::getToken());
	// 	Messages::success("Your password has been updated");
	// }
	public static function changePassword($oldPassword, $newPassword)
	{
		if (!self::loggedIn()) {
			Messages::error("Login first!");
			return;
		}

		$token = self::getToken();

		// Fetch the hashed password from the database
		$query = Db::fetch("users", "password", "token = ? ", $token, "", "", "");
		$dataCurrentPassword = Db::num($query);
		$hashedCurrentPassword = $dataCurrentPassword[0];

		// Verify old password
		if (!password_verify($oldPassword, $hashedCurrentPassword)) {
			Messages::error("Your old password could not be verified");
			return;
		}

		// Hash the new password
		$hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

		// Update the password in the database
		Db::update("users", array("password"), array($hashedNewPassword), "token = ? ", $token);

		Messages::success("Your password has been updated");
	}
}
