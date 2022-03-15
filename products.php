<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: verifylogin.php");
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <title>All products - Homemade</title>
    <link rel="stylesheet" type="text/css" href="style.css?<?php echo time();?>" />
    <link rel="stylesheet" type="text/css" href="main.css?<?php echo time();?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
      integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
      crossorigin="anonymous" />
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
              <li><a href="products.html">Products</a></li>
              <li><a href="aboutus.html">About Us</a></li>
              <li><a href="https://forms.gle/ae9NGHWYQKHcCcwm9">Contact</a></li>
              <li><a href="verifylogin.php">Logout</a></li>

            </ul>
          </nav>
          <img src="images/cart.png" width="30px" height="30px" class='cart-icon' />
          <img src="images/menu.png" class="menu-icon" onclick="menutoggle()" />
        </div>
      </div>


    <div class="small-container">
      <div class="row row-2">
        <h2 class="title">All Products</h2>
        <!-- <h2>All Products</h2> -->
        <!----- select --->
          <!-- <option>Default Shorting</option> -->
          <!-- <option>Sort by price</option> -->
          <!-- <option>Sort by popularity</option> -->
          <!-- <option>Sort by ratting</option> -->
          <!-- <option>Sort by product</option> -->
        <!---- /-->
      </div>
      <div class="row all-products">
        
      </div>
      <!-- <h2 class="title">Latest Products</h2> -->
      <div class="row latestproducts">
        
      </div>
      <div class="small-container single-product">
        <div class="row product-details-page">
          
        </div>
      </div>
      <div class="page-btn">
        <span>1</span>
        <span>2</span>
        <span>3</span>
        <span>4</span>
        <span>&#8594;</span>
      </div>
    </div>

    <!---cart-->
    <div class="cart-overlay">
      <div class="cart">
        <span class="close-cart"><i class="fa fa-times" aria-hidden="true"></i></i></span>
        <h2>your cart</h2>
        <div class="cart-content">
          <!-- cart item -->
          <!-- <div class="cart-item">
                <img src="./images/product-1.jpg" alt="product" />
                <div>
                  <h4>queen bed</h4>
                  <h5>$9.00</h5>
                  <span class="remove-item">remove</span>
                </div>
                <div>
                  <i class="fas fa-chevron-up increase"></i>
                  <p class="item-amount">
                    1
                  </p>
                  <i class="fas fa-chevron-down decrease"></i>
                </div>
              </div>  -->
          <!-- cart item -->
        </div>
        <div class="cart-footer">
          <h3>your total :Rs. <span class="cart-total">0</span></h3>
          <button class="clear-cart banner-btn">clear cart</button>
        </div>
      </div>
    </div>
    <!-- end of cart -->


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
    <script src="./products.js?<?php echo time(); ?>" type="module"></script>
  </body>
</html>
