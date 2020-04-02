<?php include("includes/header.php"); ?>
<?php include("includes/nav.php"); 
if(!isset($_SESSION['username']))
{
    // not logged in
    header('Location: login.php');
    exit();
}
?>
	<div class="jumbotron">
		<h1 class="text-center">Admin</h1>
	</div>





<?php include("includes/footer.php"); ?>