<?php
include "includes/header.php";

?>
<div class="container ">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">

                <?php validate_user_registration();
display_message();
$first_name = array_key_exists('first_name', $_POST) ? $_POST['first_name'] : "";
$last_name = array_key_exists('last_name', $_POST) ? $_POST['last_name'] : "";
$username = array_key_exists('username', $_POST) ? $_POST['username'] : "";
$email = array_key_exists('email', $_POST) ? $_POST['email'] : "";
?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-login" style="box-shadow: 0px 1px 40px rgba(0, 0, 0, .75);">
                    <div class="panel-heading">
                        <img src="img/icon-people.png" alt="circle lock" height="100" width="100" />
                        <h2 style="text-shadow: 0 4px 5px #4dd2ff;"> Jazz Music University</h2>
                        <h5> Registration Page </h5>
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="login.php">Login</a>
                            </div>
                            <div class="col-xs-6">
                                <a href="register.php" class="active" id="">Register</a>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="register-form" method="post" role="form">
                                    <div class="form-group">
                                        <input type="text" name="first_name" id="first_name" tabindex="1"
                                            class="form-control" placeholder="First Name"
                                            value="<?php echo $first_name; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="last_name" id="last_name" tabindex="1"
                                            class="form-control" placeholder="Last Name"
                                            value="<?php echo $last_name; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" tabindex="1"
                                            class="form-control" placeholder="Username" value="<?php echo $username; ?>"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" id="register_email" tabindex="1"
                                            class="form-control" placeholder="Email Address"
                                            value="<?php echo $email; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" tabindex="2"
                                            class="form-control" placeholder="Password" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirm_password" id="confirm-password"
                                            tabindex="2" class="form-control" placeholder="Confirm Password" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="register-submit" id="register-submit"
                                                    tabindex="4" class="form-control btn btn-register"
                                                    value="Register Now">

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include "includes/footer.php";?>