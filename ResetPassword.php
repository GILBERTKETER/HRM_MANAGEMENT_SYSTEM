<?php
require_once "importance.php";
$token = $_GET['token'];

$host = "localhost";
$dbname = "ntsystem";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the token exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE password_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Token not found, display an error message or redirect
        Messages::error("Invalid token. Please try again or request a new password reset.");
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle the form submission to update the password
            $newPassword = $_POST['Password'];
            $confirmPassword = $_POST['cpassword'];

            // Validate the new password
            if (strlen($newPassword) < 5) {
                Messages::error("Password must be at least 5 characters long.");
            } elseif ($newPassword !== $confirmPassword) {
                Messages::error("Passwords do not match.");
            } else {
                // Hash the new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password in the database
                $stmt = $pdo->prepare("UPDATE users SET password = ?, password_token = NULL WHERE password_token = ?");
                $stmt->execute([$hashedPassword, $token]);

                // Display success message or redirect
                Messages::success("Password updated successfully. You can now login with your new password.");
                // Config::redir("login.php"); // Uncomment if you want to redirect after successful password reset
            }
        }
    }
} catch (Exception $e) {
    Messages::error($e->getMessage());
}
?>
<html>
<title><?php echo CONFIG::SYSTEM_NAME; ?> : Reset Password</title>
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
                            <div class='badge-header'>Reset Password</div>
                        </center>
                        <div class='row'>
                            <div class='col-md-3'></div>
                            <div class='container'>
                                <div class='row'>
                                    <div class='col-md-6 mx-auto'>
                                        <div class='form-holder'>
                                            <?php Db::form(array("New Password", "Confirm Password"), 3, array("Password", "cpassword"), array("password", "password"), "Reset"); ?>
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