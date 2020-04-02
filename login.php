<?php include "includes/header.php";
?>

<div class="container ">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <?php validate_login();
activate_user();
display_message();
//if (isset($_SESSION['msg'])) {
//echo $_SESSION["msg"];
//}
?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">



                <div class="panel panel-login" style="box-shadow: 0px 1px 40px rgba(0, 0, 0, .75);">
                    <div class="panel-heading">
                        <img src="img/icon-people.png" alt="circle lock" height="100" width="100" />
                        <h2 style="text-shadow: 0 4px 5px #80dfff;"> Jazz Music University</h2>
                        <h5> Login Page </h5>
                        <img src="" width="" height="" alt="">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="login.php" class="active" id="login-form-link">Login</a>

                            </div>
                            <div class="col-xs-6">
                                <a href="register.php" id="">Register</a>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="login-form" method="post" role="form" style="display: block;">
                                    <div class="form-group">
                                        <input type="text" name="email" id="email" tabindex="1" class="form-control"
                                            placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="login-
		password" tabindex="2" class="form-control" placeholder="Password" />
                                    </div>
                                    <div class="form-group text-center">
                                        <input type="checkbox" tabindex="3" class="" name="remember" value="Yes"
                                            id="remember">
                                        <label for="remember"> Remember Me</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="login-submit" id="login-submit" tabindex="4"
                                                    class="form-control btn btn-login" value="Log In">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-center">
                                                    <a href="recover.php" tabindex="5" class="forgot-password">Forgot
                                                        Password?</a>
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
    <?php include "includes/footer.php";?>