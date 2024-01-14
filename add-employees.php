<?php
require_once "importance.php";

if (!User::loggedIn()) {
    Config::redir("login.php");
}
?>

<html>

<head>
    <title><?php echo CONFIG::SYSTEM_NAME; ?> : Add Employees</title>
    <?php require_once "inc/head.inc.php";  ?>
</head>

<body>
    <?php require_once "inc/header.inc.php"; ?>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-3'>
                <?php require_once "inc/sidebar.inc.php"; ?>
            </div> <!-- this should be a sidebar -->
            <div class='col-md-8'>
                <div class='content-area'>
                    <div class='content-header'>
                        <?php if (isset($_GET['token'])) {
                            echo "Edit Employee <small></small>";
                        } else { ?> Add Employee <?php } ?>
                    </div>
                    <?php require_once "inc/alerts.inc.php";  ?>
                    <div class='content-body'>
                        <div class='form-holder'>
                            <?php
                            $pic = "";
                            $img = "";
                            $firstName = "";
                            $secondName = "";
                            $dob = date("d-m-Y");
                            $email = "";
                            $phone = "";
                            $role = "";
                            $gender = "";
                            $doj = date("d-m-Y");
                            $sal = "";
                            $accno = "";
                            $password = "";
                            $c_password = "";
                            $token = "";

                            if (isset($_GET['token'])) {
                                $token = $_GET['token'];
                                $pic = User::get($token, "profile");
                                $img = (!empty($pic)) ? ($pic) : ("profile.png");
                                $firstName = User::get($token, "firstName");
                                $secondName = User::get($token, "secondName");
                                $dob = User::get($token, "date_of_birth");
                                $email = User::get($token, "email");
                                $phone = User::get($token, "phone");
                                $role = User::get($token, "designation");
                                $gender = User::get($token, "gender");
                                $sal = User::get($token, "salary");
                                $doj = User::get($token, "date_of_joining");
                                $accno = User::get($token, "account_no");
                                $password = User::get($token, "password");
                                $c_password = User::get($token, "c_password");
                            }

                            if (isset($_POST['fn'])) {
                                if ($token == "") {
                                    $img = $_POST['pt'];
                                } else {
                                    $img = "$img";
                                }
                                $firstName = $_POST['fn'];
                                $secondName = $_POST['sn'];
                                $dob = $_POST['dob'];
                                $email = $_POST['em'];
                                $phone = $_POST['phone'];
                                $role = $_POST['role'];
                                $doj = $_POST['doj'];
                                $sal = $_POST['sl'];
                                $accno = $_POST['acc'];
                                $password = $_POST['password'];
                                $c_password = $_POST['c_password'];
                                $gender = ($token == "") ? $_POST['gender'] : "$gender";

                                // Validate form data
                                if ($firstName == "" || $secondName == "" || $dob == "" || $email == "" || $phone == "" || $role == "" || $gender == "" || $dob == "" || $sal == "" || $accno == "" || $password == "" || $c_password == "") {
                                    Messages::error("You must fill in all the fields");
                                } else if (strlen($phone) != 10) {
                                    Messages::error("Phone must be 10 characters");
                                } else if (strpos($email, "@") === false || strpos($email, ".") === false) {
                                    Messages::error("You entered an invalid email. Email must be in the form of example@example.com");
                                } else if ($password != $c_password) {
                                    Messages::error("Password and Confirm Password must match");
                                } else {
                                    // Call the Employee::add method to insert or update the employee details in the database
                                    Employee::add($token, $firstName, $secondName, $dob, $email, $phone, $img, $gender, $role, $doj, $sal, $accno, $password);
                                }
                            }

                            $form = new Form(3, "post");
                            $form->init();
                            //Begin adding or editing photo
                            if (isset($_GET['token'])) {
                                echo "
                                    <div class='form-group'>
                                        <label class='col-md-3'>Photo</label>
                                        <div class='col-md-9'>
                                            <img src='images/$img' width='70px' height='70px'> 
                                        </div> 
                                    </div> 
                                ";
                            } else {
                                echo "
                                    <div class='form-group'>
                                        <label class='col-md-3'>Photo</label>
                                        <div class='col-md-9'>
                                            <input type='file' name='pt' id='pt'>
                                        </div> 
                                    </div> 
                                ";
                            } // end
                            $form->textBox("First Name", "fn", "text", "$firstName", "");
                            $form->textBox("Second Name", "sn", "text", "$secondName", "");
                            $form->textBox("Date Of Birth", "dob", "date", "$dob", "");
                            $form->textBox("Email", "em", "text", "$email", "");
                            $form->textBox("Phone", "phone", "number", "$phone", "");
                            $form->textBox("Designation", "role", "text", "$role", "");
                            if (isset($_GET['token'])) {
                                $form->textBox("Gender", "", "text", "$gender", array("disabled"));
                            } else {
                                $form->select("Gender", "gender", "", array("Male", "Female", "Other"));
                            }
                            $form->textBox("Date Of Joining", "doj", "date", "$doj", "");
                            $form->textBox("Salary", "sl", "text", "$sal", "");
                            $form->textBox("Account No.", "acc", "text", "$accno", "");
                            $form->textBox("Password", "password", "password", "$password", "");
                            $form->textBox("Confirm Password", "c_password", "password", "$c_password", "");
                            if (isset($_GET['token'])) {
                                $form->close("Edit Employee");
                            } else {
                                $form->close("Add Employee");
                            }
                            ?>
                        </div>
                    </div><!-- end of the content area -->
                </div>
            </div><!-- col-md-7 -->
            <div class='col-md-3'>
            </div> <!-- this should be a sidebar -->
        </div>
    </div>
</body>

</html>
