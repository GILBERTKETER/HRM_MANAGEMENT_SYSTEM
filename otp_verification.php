<?php
require_once "importance.php";

if (!User::loggedIn()) {
    Config::redir("login.php");
}

$loggedInUserToken = User::getToken();

if (isset($_POST['verification_code'])) {
    $enteredOTP = $_POST['verification_code'];
    $host = "localhost";
    $dbname = "ntsystem";
    $username = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the SQL query to fetch OTP for the logged-in user
        $stmt = $pdo->prepare("SELECT otp FROM users WHERE token = ?");
        $stmt->execute([$loggedInUserToken]);
        $storedOTP = $stmt->fetchColumn();

        if ($enteredOTP == $storedOTP) {
            $token = User::getToken();
            Db::update("users", array("otp"), array(0), "token = ?", $token);

            // OTP verification successful
            Messages::success("OTP verification successful. Redirecting to the dashboard...");
            Config::redir("index.php");
        } else {
            // Incorrect OTP
            Messages::error("Incorrect OTP. Please try again.");
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Connection failed: " . $e->getMessage();
    }
}
?>

<html>
<title><?php echo CONFIG::SYSTEM_NAME; ?> : OTP Verification</title>
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
                            <div class='badge-header'>Please Enter the OTP received in your Email Address</div>
                        </center>
                        <div class='row'>
                            <div class='col-md-3'></div>
                            <div class='container'>
                                <div class='row'>
                                    <div class='col-md-6 mx-auto'>
                                        <div class='form-holder'>
                                            <?php Db::form(array("Verification code"), 3, array("verification_code"), array("number"), "verify"); ?>
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