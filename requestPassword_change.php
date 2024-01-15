<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require './PHPMailer/src/Exception.php';
// require './PHPMailer/src/PHPMailer.php';
// require './PHPMailer/src/SMTP.php';

require_once "importance.php";
if (isset($_POST['Email'])) {
    $email = $_POST['Email'];
    $host = "localhost";
    $dbname = "ntsystem";
    $username = "root";
    $password = "";
    $token_length = 32;


    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            Messages::error("Email not found. Please enter a valid email address.");
        } else {
            $password_token = generatePasswordToken($token_length);

            $stmt = $pdo->prepare("UPDATE users SET password_token = ? WHERE email = ?");
            $stmt->execute([$password_token, $email]);
            $link = "http://localhost/HR_MANAGEMENT_SYSTEM/ResetPassword.php?token=$password_token";
            sendPasswordResetEmail($email, $link);
            Messages::success("Password reset email sent successfully. Please check your email for further instructions.");
            // Config::redir("login.php");
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
function sendPasswordResetEmail($email, $link)
{
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true); // Set true to enable exceptions
    $subject = "Password Reset Link";
    $message = "
        <html>
        <head>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    background-color: #f4f4f4;
                    color: #333;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 50px auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                h1 {
                    color: #3498db;
                }
                p {
                    line-height: 1.6;
                }
                a {
                    color: #3498db;
                    text-decoration: none;
                    font-weight: bold;
                }
                a:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>Password Reset</h1>
                <p>Please click the link below to change your account password:</p>
                <p><a href='$link'>$link</a></p>
            </div>
        </body>
        </html>
    ";

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
        $mail->addAddress($email); // Recipient email

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
        // $error = "Password reset link sent to $email. Please check your email.";
    } catch (Exception $e) {
        Messages::error("Error sending reset link: {$mail->ErrorInfo}");
    }
}
function generatePasswordToken($length)
{
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $password_token = '';
    $characters_length = strlen($characters);

    for ($i = 0; $i < $length; $i++) {
        $password_token .= $characters[rand(0, $characters_length - 1)];
    }

    return $password_token;
}
?>
<html>
<title><?php echo CONFIG::SYSTEM_NAME; ?> : Password</title>
<?php require_once "inc/head.inc.php"; ?>

<head>
</head>

<body>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-1'></div>
            <div class='col-md-4'></div>
            <div class='col-md-15'>
                <div class='content-area'>
                    <div class='content-header'></div>
                    <div class='content-body'>
                        <center>
                            <div class='badge-header'>Enter your Email Address</div>
                        </center>
                        <div class='row'>
                            <div class='col-md-3'></div>
                            <div class='container'>
                                <div class='row'>
                                    <div class='col-md-6 mx-auto'>
                                        <div class='form-holder'>
                                            <?php Db::form(array("Email Address"), 3, array("Email"), array("text"), "Request"); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-3'></div>
                        </div><!-- end of the content area -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'inc/footer.inc.php'; ?>
</body>

</html>