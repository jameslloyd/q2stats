<?php
include('../config.php');
include ('../Thirdparty/GoogleAuth/GoogleOpenID.php');
  $googleLogin = GoogleOpenID::getResponse();
  if($googleLogin->success()){
    $user_id = $googleLogin->identity();
    $user_email = $googleLogin->email();
    $user_firstname = $googleLogin->firstname();
    $user_lastname = $googleLogin->lastname();
    $_SESSION['loggedin']='true';
    $_SESSION['fname']=$_GET['openid_ext1_value_firstname'];
    $_SESSION['lname']=$_GET['openid_ext1_value_lastname'];
    $_SESSION['email']=$_GET['openid_ext1_value_email'];
    header('Location: ' . $_SESSION['loginreturn'] );  //returns to the page you clicked login on, using the HTTP_REFFER from login.php
  } else {
      echo 'login failed';
      session_destroy();
  }

?>
