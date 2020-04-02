<?php
// Initialize the session.
session_start();
// Unset all of the session variables.
unset($_SESSION['username']);
// Finally, destroy the session.    
session_destroy();

/* // if we need to delete cookie when ser logs out then do the following
 *  if(isset($_COOKIE['email'])) {
 *  unset($_COOKIE['email']);
 *  setcookie('email', '', time()-2*24*60*60 );
 */


// Include URL for Login page to login again.
header("Location: login.php");
exit;
?>