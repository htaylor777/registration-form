<?php include "includes/header.php";
$email = ($_GET['email']);
$_SESSION['email'] = $email;
check_reset_code();

?>

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">


    </div>
</div>


<div class="row">
    <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3">
        <div class="alert-placeholder">

        </div>
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php display_message();?>
                        <div class="text-center">
                            <img src="img/lock-png-circle.png" alt="circle lock" height="100" width="100" />
                            <h2><b> Password Reset </b></h2>
                        </div>
                        <form id="register-form" method="post" role="form" autocomplete="off">
                            <div class="form-group">
                                <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>" />
                                <input type="text" name="code" id="code" tabindex="1" class="form-control"
                                    placeholder="enter code" value="" autocomplete="off" required />
                            </div>
                            <div class="form-group">
                                <div class="row">

                                    <div
                                        class="col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-2 col-sm-3 col-sm-offset-2  col-xs-6">
                                        <input type="submit" name="code-cancel" id="code-cancel" tabindex="2"
                                            class="form-control btn btn-danger" value="Cancel" />

                                    </div>
                                    <div
                                        class="col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-2 col-sm-3 col-sm-offset-2 col-xs-6">
                                        <input type="submit" name="code-submit" id="recover-submit" tabindex="2"
                                            class="form-control btn btn-success" value="Continue" />

                                    </div>

                                </div>
                            </div>
                            <input type="hidden" class="hide" name="token" id="token" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php";?>