<?php
include "includes/header.php";

if (!isset($_SESSION['approved'])) {
    // if  not approved for reset go back to recover
    header('Location: recover.php');
    exit();
}

reset_password();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/scripts.js"></script>
</head>

<body>

    <div class="container">

        <div class="row">

        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-login">
                    <div class="panel-heading">
                        <div class="row">
                            <?php display_message();?>
                            <div class="col-xs-12">
                                <h3>Reset Password</h3>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="register-form" method="post" role="form">

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
                                                <input type="hidden" name="email"
                                                    value="<?php echo $_SESSION['email']; ?>" />
                                                <input type="submit" name="reset-password-submit"
                                                    id="reset-password-submit" tabindex="4"
                                                    class="form-control btn btn-register" value="Reset Password">
                                                <hr />
                                                <!-- button class="form-control btn btn-register"
                                                    onclick="window.location.href = 'login.php';">Login</button -->
                                            </div>
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
    </div>

</body>

</html>