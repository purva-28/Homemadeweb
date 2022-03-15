<?php
require_once "config.php";

$username = $password = $confirm_password = $emergency_email=  $city = $state = $message = $email_add= $zip = "";
$username_err = $password_err = $confirm_password_err = $emergency_email_err = $city_err = $state_err = $message_err = $email_add_err = $zip_err= "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Username cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
            
        }
        mysqli_stmt_close($stmt);
    }

//check for email
if(empty(trim($_POST['emergency_email']))){
    $emergency_email_err = "Email address cannot be blank";
}

elseif(!filter_var($_POST['emergency_email'], FILTER_VALIDATE_EMAIL)){
    $emergency_email_err = "Invalid email format";
}

else {
  $emergency_email = trim($_POST['emergency_email']);
}


//check for useremail
if(empty(trim($_POST['email_add']))){
    $email_add_err = "Email address cannot be blank";
}

elseif(!filter_var($_POST['email_add'], FILTER_VALIDATE_EMAIL)){
    $email_add_err = "Invalid email format";
}

else {
  $email_add = trim($_POST['email_add']);
} 

//check for city
if(empty(trim($_POST['city']))){
    $city_err = "city cannot be blank";
}else {
  $city = trim($_POST['city']);
} 

//check for state
if(empty(trim($_POST['state']))){
    $state_err = "State cannot be blank";
}else {
  $state = trim($_POST['state']);
} 

//check for zip
if(empty(trim($_POST['zip']))){
    $zip_err = "zip cannot be blank";
}else {
  $zip = trim($_POST['zip']);
} 

//check for message
if(empty(trim($_POST['message']))){
    $message_err = "Message cannot be blank";
}else {
  $message = trim($_POST['message']);
} 

// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
}


// If there were no errors, go ahead and insert into the database
if(empty($username_err) &&empty($email_add_err) && empty($password_err) && empty($confirm_password_err)  && empty($emergency_email_err) && empty($zip_err)  &&empty($city_err) &&empty($state_err)  &&empty($message_err))
{
    $sql = "INSERT INTO users (username, email_add, password, emergency_email, city, state,zip, message) VALUES (?, ?, ? ,? ,?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ssssssss", $param_username, $param_email_add ,$param_password, $param_emergency_email, $param_city, $param_state,$param_zip ,$param_message);

        // Set these parameters
        $param_username = $username;
        $param_email_add = $email_add;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $param_emergency_email = $emergency_email;
        $param_city = $city;
        $param_state = $state;
        $param_zip = $zip;
        $param_message = $message;

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: login.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
       
    }
   mysqli_stmt_close($stmt);
}


mysqli_close($conn);
}

?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>PHP login system!</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Php Login System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
  <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="register.php">Register</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>

      
     
    </ul>
  </div>
</nav>

<div class="container mt-4">
<h3>Please Register Here:</h3>
<hr>
<form action="" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Your Username</label>
      <input type="text" class="form-control" name="username" id="inputEmail4" placeholder="johndoe" >
      <span class="error">* <?php echo $username_err;?></span>
    </div>
  </div>

   <div class="form-row">
    <div class="form-group col-md-6">
      <label for="email_add">Your Email Address</label>
      <input type="email" class="form-control" name="email_add" id="email_add" placeholder="johndoe@example.com" >
      <span class="error">* <?php echo $email_add_err;?></span>
    </div>
  </div>


  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password">
      <span class="error">* <?php echo $password_err;?></span>
    </div>
    <div class="form-group col-md-3">
      <label for="confirm_password">Confirm Password</label>
      <input type="password" class="form-control" id="confirm_password" name="confirm_password">
      <span class="error">* <?php echo $confirm_password_err;?></span>
    </div>
  </div>


  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="emergency_email">Emergency Contact's Email Address</label>
      <input type="email" class="form-control" id="emergency_email" name="emergency_email" placeholder="xyz@example.com">
      <span class="error">* <?php echo $emergency_email_err;?></span>
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="city">City</label>
      <input type="text" class="form-control" id="city" name="city">
      <span class="error">* <?php echo $city_err;?></span>
    </div>
    <div class="form-group col-md-2">
      <label for="state">State</label>
      <input id="state" class="form-control" type="text" name="state">
      <span class="error">* <?php echo $state_err;?></span>

    </div>
    <div class="form-group col-md-1">
      <label for="zip">Zip</label>
      <input type="text" class="form-control" id="zip" name="zip">
      <span class="error">* <?php echo $zip_err;?></span>
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="message">Message to be sent</label>
      <input type="text" class="form-control" id="message" name="message" placeholder="Type your message...">
      <span class="error">* <?php echo $message_err;?></span>
    </div>
  </div>

  <button type="submit" class="btn btn-primary">Sign in</button>
</form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
