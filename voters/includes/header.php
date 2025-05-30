<?php
    session_start();
    require_once("../admin/includes/config.php");

    if($_SESSION['key'] != "VotersKey")
    {
         echo"<script>location.assign('../admin/logout.php');</script>";
        die;
    }
   

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Panel-Online voting system</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

   
</head>
<body>

<div class="row  bg-light  text-black">
    <div class="container-fluid">
        <div class="row  bg-light  text-black">
            <div class="col-1"> 
            <img src="../assets/images/logoicon.gif" alt="" width="80px"/>    
            </div>
            <div class="col-11 my-auto"> 
                <h3>ONLINE VOTING SYSTEM- <small>Welcome <?php echo $_SESSION['username'];?></small></h3>
             </div> 
           
        </div>
       
        
    </div>
</div>
    
