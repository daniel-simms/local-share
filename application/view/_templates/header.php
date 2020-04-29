<?php 
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MINI</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- JS -->
    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->
    <!-- See more here: http://stackoverflow.com/q/2105327/1114320 -->

     <!-- Compiled and minified CSS -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- CSS -->
    <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">

    <!-- jQuery, loaded in the recommended protocol-less way -->
    <!-- more http://www.paulirish.com/2010/the-protocol-relative-url/ -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>



    <nav>
      <span href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></span>
      <div class="nav-wrapper">
        <a href="<?=URL?>" class="brand-logo center"><i class="material-icons">share</i></a>
    </div>
  </nav>


  <ul id="slide-out" class="sidenav">
    <?php if($this->is_loggedin()){ ?>
      <li><div class="user-view">
        <div class="background" style="background:#26a69a"></div>
        <a href="#user"><img class="circle" src="<?=URL?>public/<?=$_SESSION['user_session']->image?>"></a>
        <a href="#name"><span class="white-text name">Hello, <?=$_SESSION['user_session']->username?></span></a>
        <a href="#email"><span class="white-text email"><?=$_SESSION['user_session']->email?></span></a>
      </div></li>
    <?php } ?>

    <li><a class="subheader">Pages</a></li>
    
    <li><a class="waves-effect" href="<?=URL?>"><?php echo($this->is_loggedin())? "Feed" : "Home" ?></a></li>
    <!-- <li><a href="<?php echo URL; ?>songs">Songs</a></li> -->

    <li><div class="divider"></div></li>

    <li><a class="subheader">Account</a></li>
    <?php if($this->is_loggedin()){ ?>
    <li><a href="<?php echo URL; ?>user">User</a></li>
    <li><a href="<?=URL?>user/logout/true"><b><i class="tiny material-icons" id="logout-icon" >power_settings_new</i> Logout</b></a></li>
    <?php } else { ?>
        <li><a href="<?=URL?>user/login"><b><i class="tiny material-icons" id="logout-icon" >power_settings_new</i> Login/ Register</b></a></li>
    <?php } ?>

    
    
  </ul>


