

<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<!------ Include the above in your HEAD tag ---------->

<?php
    require_once("admin/includes/config.php");

    $fetchingElections = mysqli_query($db,"SELECT * FROM elections") or die(mysqli_error($db));
    while($data = mysqli_fetch_assoc($fetchingElections))
    {
        $starting_date = $data['starting_date'];
        $ending_date = $data['ending_date'];
        $current_date = date('y-m-d');
        $election_id = $data['id'];
        $status = $data['status'];

        // active-expire-endingdate
        // inactive-active-starting date
        if($status=='Active')
        {
            $date1=date_create($current_date);
            $date2=date_create($ending_date);
            $diff=date_diff($date1,$date2);
          
     
            if( (int)$diff->format("%R%a")<0)
             {
                // update status 
                mysqli_query($db,"UPDATE elections SET status = 'Expired' WHERE id ='".$election_id."' ") OR die (mysqli_error($db));
             }
     
        }else if($status == 'InActive')
        {
            $date1=date_create($current_date);
            $date2=date_create($starting_date);
            $diff=date_diff($date1,$date2);
          
      echo (int)$diff->format("%R%a");
            if( (int)$diff->format("%R%a")<=0)
             {
                mysqli_query($db,"UPDATE elections SET status = 'Active' WHERE id ='".$election_id."' ") OR die (mysqli_error($db));
             }

        }
        else{

        }
       
    }
?>


<!DOCTYPE html>
<html>
    
<head>
	<title>Online voting system</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/signup.css">
</head>

<body>
<?php
                    if(isset($_GET[ 'registered' ]))
                    {
                    ?>
                  <div  class="alert alert-success" role="alert">
  <strong>SUCCESS</strong> Your Account has been created successfully!
  </div>
  

                   
                    <?php 
                    } else if(isset($_GET[ 'invalid' ]))
                    {
                    ?>
                      <div class="alert alert-danger" role="alert">
  <strong>FAIL</strong> Password Mismatched, Please Try Again!</div>

                    <?php    
                     }  else if(isset($_GET[ 'not_registered' ]))
                     {
                     ?>
                       <div class="alert alert-warning " role="alert">
   <strong>Sorry</strong> You are not registered!! </div>
 <?php    
                     }  else if(isset($_GET[ 'invalid_access' ]))
                     {
                     ?>
                       <div class="alert alert-danger " role="alert">
   <strong>Fail </strong>Invalid user name or password ! </div>
                  <?php
                     }   
                    ?>

<!-- signup session -->
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="assets/images/logoicon.gif"  class="brand_logo" alt="Logo">
                        
					</div>
				</div>
                <?php
                 if(isset($_GET['sign-up']))
                    {
                ?>
                 <div class="d-flex justify-content-center form_container">
                            <form method="POST">
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="su_username" class="form-control input_user" minlength='7' maxlength='7'  placeholder="Username(Roll Number)" required/>
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="text" name="su_contactno" class="form-control input_pass" minlength="10" maxlength='10' placeholder="Contact (+91)" required/>
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" name="su_password" class="form-control input_pass"  placeholder="Password(4-13 character)" minlength='4' maxlength='13' required/>
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password"  name="su_confirmpassword" class="form-control input_pass"  placeholder="Confirm Password" required/>
                                </div>
                               
                                    <div class="d-flex justify-content-center mt-3 login_container">
                            <button type="submit" name="sign_up_btn" class="btn login_btn ">Sign Up</button>
                        </div>
                            </form>
                        </div>
                        <div class="mt-4">
                            <div class="d-flex justify-content-center links text-white">
                                Already Created Account ?<a href="index.php" class="ml-2 text-white">Sign In</a>
                            </div>
                        </div>
                        
                <?php

                    }

                //  <!--- login page ---> 
                 else
                    {
                ?>
                            <div class="d-flex justify-content-center form_container">
                            <form method="POST">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="username" class="form-control input_user"  placeholder="User" required/>
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control input_pass" placeholder="password" required/>
                                </div>
                                <div class="d-flex justify-content-center mt-3 login_container">
                            <button type="submit" name="loginbtn" class="btn login_btn">Login</button>
                        </div>  
                            </form>
                        </div>
                        
                        <div class="mt-4">
                            <div class="d-flex justify-content-center links text-white">
                                Don't have an account? <a href="?sign-up=1" class="ml-2 text-white">Sign Up</a>
                            </div>
                            <!-- <div class="d-flex justify-content-center links">
                                <a href="#" class="text-white">Forgot your password?</a>
                            </div> -->
                        </div>
                        <?php
                    }
                    ?>
                  
			</div>
		</div>
	</div>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
</body>
</html>

<?php
   // su_username    su_contactno   su_password   su_confirmpassword   sign_up_btn
        require_once("admin/includes/config.php");
        if(isset($_POST['sign_up_btn']))
        {
            $su_username =mysqli_real_escape_string($db,$_POST['su_username']);
            $su_contactno =mysqli_real_escape_string($db,$_POST['su_contactno']);
            $su_password =mysqli_real_escape_string($db,sha1($_POST['su_password']));
            $su_confirmpassword =mysqli_real_escape_string($db,sha1($_POST['su_confirmpassword']));
            $user_role="Voter";
            if($su_password==$su_confirmpassword)
            {
                //Query to Insert
                mysqli_query($db,"INSERT INTO users(username,contact_no,password,user_role) VALUES('".$su_username."','".$su_contactno."','".$su_password."','".$user_role."')")or die(mysqli_error($db));

    ?>
           <script>location.assign("index.php?sign-in=1&registered=1");</script>   

    <?php
                
 
            }else{

     ?>
            <script>location.assign("index.php?sign-up=1&invalid=1");</script>   
<?php            
            }
        }
        // username   password 
        elseif(isset($_POST['loginbtn']))
        {
            $username  =mysqli_real_escape_string($db,$_POST['username']);
            $password   =mysqli_real_escape_string($db,sha1($_POST['password']));

            //Query for fetching 
            $fetchingdata= mysqli_query($db,"SELECT * FROM users WHERE username= '". $username."'") or die(mysqli_error($db));

            // echo $data['username'];

            if(mysqli_num_rows($fetchingdata)>0)
            {
                $data = mysqli_fetch_assoc($fetchingdata);
                if($username == $data['username'] and $password == $data['password'])
                {
                    session_start();
                    $_SESSION['user_role']=$data['user_role'];
                    $_SESSION['username']=$data['username'];
                    $_SESSION['user_id'] = $data['id'];

                    
                    
                    
                    if($data['user_role'] == "Admin")
                    {
                        $_SESSION['key'] ='AdminKey';
                        ?>
<script>location.assign("admin/index.php?homepage=1.php");</script>  


<?php
                    }else{
                        $_SESSION['key']='VotersKey';
                        ?>
<script>location.assign("voters/index.php");</script>   

<?php
                    }

                }else{
                    ?>
                    <script>location.assign("index.php?invalid_access=1");</script>   

                    <?php
                }

            } else{

                ?>

<script>location.assign("index.php?sign-up=1&not_registered=1");</script>   

                <?php
            }


        }


?>