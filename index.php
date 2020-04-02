<?php
include "includes/header.php";
include "includes/nav.php";
if (!isset($_SESSION['username'])) {
    // not logged in
    header('Location: login.php');
    exit();
}

?>
<div class="jumbotron">
    <h1 class="text-center">HOME</h1>

    <?php

echo '<pre> logged in as: <strong>' . $_SESSION['username'] . '</strong></pre>';
echo "test:" . $_SESSION['username'];
// test: echo token_generator();

?>

</div>



<?php include "includes/footer.php";?>