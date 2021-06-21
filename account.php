<?php 


require_once "config.php";

//register
$username = $password = $confirm_password = $email_add= "";
$username_err = $password_err = $confirm_password_err = $email_add_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

  // Check if username is empty
    if(empty(trim($_POST["usernameReg"]))){
        $username_err = "Username cannot be blank";
    }
    else{
       $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['usernameReg']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                }
                else{
                    $username = trim($_POST['usernameReg']);
                }
            }
            else{
                echo "Something went wrong";
            }
            
        }
        mysqli_stmt_close($stmt);
    
    }

    //check for useremail
    if(empty(trim($_POST['emailAddReg']))){
        $email_add_err = "Email address cannot be blank";
    }

    elseif(!filter_var($_POST['emailAddReg'], FILTER_VALIDATE_EMAIL)){
        $email_add_err = "Invalid email format";
    }

    else {
      $email_add = trim($_POST['emailAddReg']);
    } 


    //check for password
    // Check for password
    if(empty(trim($_POST['passwordReg']))){
        $password_err = "Password cannot be blank";
    }
    elseif(strlen(trim($_POST['passwordReg'])) < 5){
        $password_err = "Password cannot be less than 5 characters";
    }
    else{
        $password = trim($_POST['passwordReg']);
    }

    // Check for confirm password field
    if(trim($_POST['passwordReg']) !=  trim($_POST['confirmPasswordReg'])){
        $password_err = "Passwords should match";
    }

    if(empty($username_err) &&empty($email_add_err) && empty($password_err) && empty($confirm_password_err))
{
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email_add ,$param_password);

        // Set these parameters
        $param_username = $username;
        $param_email_add = $email_add;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: verifylogin.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
       
    }
   mysqli_stmt_close($stmt);
}

}

?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <title>All products - Homemade</title>
     <link rel="stylesheet" type="text/css" href="style.css?<?php echo time();?>" />
    
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,700;1,500;1,600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet"
    href=https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css>
  </head>
  <body>
    <div class="container">
      <div class="navbar">
        <div class="logo">
          <img src="images/logo.png" width="125px" />
        </div>
        <nav>
          <ul id="MenuItems">
            <li><a href="index.html">Home</a></li>
            <li><a href="verifylogin.php">Products</a></li>
            <li><a href="aboutus.html">About Us</a></li>
            <li><a href="https://forms.gle/ae9NGHWYQKHcCcwm9">Contact</a></li>
            <li><a href="account.html">Account</a></li>
          </ul>
        </nav>
        <a href="cart.html"><img src="images/cart.png" width="30px" height="30px" /></a>
        <img src="images/menu.png" class="menu-icon" onclick="menutoggle()" />
      </div>
    </div>
    <!-----------------account page----------------------------------------------------------->
    <div class="account-page">
      <div class="container">
        <div class="row">
          <div class="col-2">
            <img src="images/image1.png" width="100%">
          </div>
          <div class="col-2">
            <div class="form-container">
              <div class="form-btn">
                <!-- <span onclick="login()"> Login </span> -->
                <span > Register </span>
                <hr id='Indicator'>
              </div>
              
              <form id="RegForm"  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

               <!-- username -->
                   <label for="usernameReg">Your Username</label>
                    <input type="text" name="usernameReg" id="usernameReg" placeholder="johndoe" >
                    <!-- <span class="error">* <?php echo $username_err;?></span> -->

                <!-- email -->
                    <label for="emailAddReg">Your Email Address</label>
                    <input type="email" name="emailAddReg" id="emailAddReg" placeholder="johndoe@example.com" >
                    <!-- <span class="error">* <?php echo $email_add_err;?></span> -->

                <!-- password -->
                   <label for="passwordReg">Password</label>
                   <input type="password" id="passwordReg" name="passwordReg">
                   <!-- <span class="error">* <?php echo $password_err;?></span> -->

                <!-- confirm pass -->
                <label for="confirmPasswordReg">Confirm Password</label>
                <input type="password" id="confirmPasswordReg" name="confirmPasswordReg">
                <!-- <span class="error">* <?php echo $confirm_password_err;?></span> -->


                <!-- submit -->
                  <button type='submit' class='btn'>Register</button>

               <p class="bottom">Already Registered?<a href="verifylogin.php" class="bottom-a">  Log in</a></p>  
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!----------------------footer-------------------------->
    <div class="footer">
      <div class="container">
        <div class="row">
          <div class="footer-col-1">
            <h3>Download Our App</h3>
            <p>Download App for Android and ios mobile phone</p>
            <div class="app-logo">
              <img src="images/play-store.png" />
              <img src="images/app-store.png" />
            </div>
          </div>
          <div class="footer-col-2">
            <img src="images/logo-white.png" alt="" />
            <p>
              Our Purpose Is To Sustainably Make The Pleasure and Benefits of
              Sports Accessible to the Many
            </p>
          </div>
          <div class="footer-col-3">
            <h3>Useful Links</h3>
            <ul>
              <li>Coupons</li>
              <li>Blog Post</li>
              <li>Return Policy</li>
              <li>Coupons</li>
              <li>Join Affiliate</li>
            </ul>
          </div>
          <div class="footer-col-4">
            <h3>Follow us</h3>
            <ul>
              <li>Facebook</li>
              <li>Twitter</li>
              <li>Instagram</li>
              <li>Youtube</li>
            </ul>
          </div>
        </div>
        <hr />
        <p class="Copyright">Copyright 2020 - BatchB : Purva Shruti RIA</p>
      </div>
    </div>
    <!--------------------js for toggle menu---------------------------->
    <script>
      var MenuItems = document.getElementById("MenuItems");
      MenuItems.style.maxHeight = "0px";
      function menutoggle() {
        if (MenuItems.style.maxHeight == "0px") {
          MenuItems.style.maxHeight = "200px";
        } else {
          MenuItems.style.maxHeight = "0px";
        }
      }
    </script>
     <!--------------------js for toggle form---------------------------->
   <!--  <script>
      var loginform = document.getElementById('loginform');
      var RegForm = document.getElementById('RegForm');
      var Indicator = document.getElementById("Indicator");
      function register(){
        RegForm.style.transform = "translateX(0px)";
        loginform.style.transform = "translateX(0px)";
        Indicator.style.transform = "translateX(100px)";
      }
      function login(){
        RegForm.style.transform = "translateX(300px)";
        loginform.style.transform = "translateX(300px)";  
        Indicator.style.transform = "translateX(0px)";
      }
    </script> -->
  </body>
</html>