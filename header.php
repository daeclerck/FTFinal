<html>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
}

select {
  height: 3.5%;
}

.w3-bar .w3-button {
  padding: 16px;
}

/* Full height image header */
.bgimg-1 {
  background-position: center;
  background-size: cover;
  background-image: url("Fitness-Index-Image.jpg");
  min-height: 100%;
}

/* Full heigh image for user pages */
.bgimg-2 {
  background-position: center;
  background-size: cover;
  background-image: url("../Fitness-Menu-BG.jpg");
  min-height: 100%;
}
</style>

<!-- Navbar (sit on top) -->
<div class="w3-top">
    <div class="w3-bar w3-white w3-card" id="myNavbar">
        <?php
        if(stripos($_SERVER['REQUEST_URI'], 'index.php')) {
            echo '<a href="./index.php" class="w3-bar-item w3-button w3-wide">HOME</a>';
        } else {
            echo '<a href="../index.php" class="w3-bar-item w3-button w3-wide">HOME</a>';
        }
        ?>
    <!-- Right-sided navbar links -->
    <div class="w3-right w3-hide-small">
      <?php 
            // Check if user is on the home page or a user specific page
            if(!stripos($_SERVER['REQUEST_URI'], 'index') && stripos($_SERVER['REQUEST_URI'], '.php')) {
                echo '<a href="../User/user.php" class="w3-bar-item w3-button"><i class="fa fa-user"></i> USERS</a>';
                echo '<a href="../Food/food.php" class="w3-bar-item w3-button"><i class="fa fa-glass"></i> FOOD</a>';
                echo '<a href="../Food/foodINFO.php" class="w3-bar-item w3-button"><i class="fa fa-heart"></i> FOOD INFO</a>';
                echo '<a href="../Meal/meal.php" class="w3-bar-item w3-button"><i class="fa fa-cutlery"></i> MEAL</a>';
                echo '<a href="../Meal/mealINFO.php" class="w3-bar-item w3-button"><i class="fa fa-history"></i> MEAL HISTORY</a>';
                echo '<a href="../Weight/weight.php" class="w3-bar-item w3-button"><i class="fa fa-area-chart"></i> WEIGHT</a>';
                echo '<a href="../Workout/workout.php" class="w3-bar-item w3-button"><i class="fa fa-heartbeat"></i> WORKOUT</a>';
            } else {
                echo '<a href="./User/user.php" class="w3-bar-item w3-button"><i class="fa fa-user"></i> USERS</a>';
                echo '<a href="./Food/food.php" class="w3-bar-item w3-button"><i class="fa fa-glass"></i> FOOD</a>';
                echo '<a href="./Food/foodINFO.php" class="w3-bar-item w3-button"><i class="fa fa-heart"></i> FOOD INFO</a>';
                echo '<a href="./Meal/meal.php" class="w3-bar-item w3-button"><i class="fa fa-cutlery"></i> MEAL</a>';
                echo '<a href="./Meal/mealINFO.php" class="w3-bar-item w3-button"><i class="fa fa-history"></i> MEAL HISTORY</a>';
                echo '<a href="./Weight/weight.php" class="w3-bar-item w3-button"><i class="fa fa-area-chart"></i> WEIGHT</a>';
                echo '<a href="./Workout/workout.php" class="w3-bar-item w3-button"><i class="fa fa-heartbeat"></i> WORKOUT</a>';
            }
      ?>
    </div>
    <!-- Hide right-floated links on small screens and replace them with a menu icon -->

    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
      <i class="fa fa-bars"></i>
    </a>
  </div>
</div>

<!-- Sidebar on small screens when clicking the menu icon -->
<nav class="w3-sidebar w3-bar-block w3-black w3-card w3-animate-left w3-hide-medium w3-hide-large" style="display:none" id="mySidebar">
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">Close ×</a>
    <?php 
            // Check if user is on the home page or a user specific page
            if(!stripos($_SERVER['REQUEST_URI'], 'index') && stripos($_SERVER['REQUEST_URI'], '.php')) {
                echo '<a href="../User/user.php" class="w3-bar-item w3-button"><i class="fa fa-user"></i> USERS</a>';
                echo '<a href="../Food/food.php" class="w3-bar-item w3-button"><i class="fa fa-glass"></i> FOOD</a>';
                echo '<a href="../Food/foodINFO.php" class="w3-bar-item w3-button"><i class="fa fa-heart"></i> FOOD INFO</a>';
                echo '<a href="../Meal/meal.php" class="w3-bar-item w3-button"><i class="fa fa-cutlery"></i> MEAL</a>';
                echo '<a href="../Meal/mealINFO.php" class="w3-bar-item w3-button"><i class="fa fa-history"></i> MEAL HISTORY</a>';
                echo '<a href="../Weight/weight.php" class="w3-bar-item w3-button"><i class="fa fa-area-chart"></i> WEIGHT</a>';
                echo '<a href="../Workout/workout.php" class="w3-bar-item w3-button"><i class="fa fa-heartbeat"></i> WORKOUT</a>';
            } else {
                echo '<a href="./User/user.php" class="w3-bar-item w3-button"><i class="fa fa-user"></i> USERS</a>';
                echo '<a href="./Food/food.php" class="w3-bar-item w3-button"><i class="fa fa-glass"></i> FOOD</a>';
                echo '<a href="./Food/foodINFO.php" class="w3-bar-item w3-button"><i class="fa fa-heart"></i> FOOD INFO</a>';
                echo '<a href="./Meal/meal.php" class="w3-bar-item w3-button"><i class="fa fa-cutlery"></i> MEAL</a>';
                echo '<a href="./Meal/mealINFO.php" class="w3-bar-item w3-button"><i class="fa fa-history"></i> MEAL HISTORY</a>';
                echo '<a href="./Weight/weight.php" class="w3-bar-item w3-button"><i class="fa fa-area-chart"></i> WEIGHT</a>';
                echo '<a href="./Workout/workout.php" class="w3-bar-item w3-button"><i class="fa fa-heartbeat"></i> WORKOUT</a>';
            }
      ?>
</nav>

<script>
// Toggle between showing and hiding the sidebar when clicking the menu icon
var mySidebar = document.getElementById("mySidebar");

function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
  } else {
    mySidebar.style.display = 'block';
  }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}
</script>
</html>