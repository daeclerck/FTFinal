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
</style>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-card" id="myNavbar">
    <a href="./index.php" class="w3-bar-item w3-button w3-wide">HOME</a>
    <!-- Right-sided navbar links -->
    <div class="w3-right w3-hide-small">
    <?php 
    if(stripos($_SERVER['REQUEST_URI'], 'user.php')) {
        echo '<a class="w3-bar-item w3-button"><i class="fa fa-user"></i> USERS</a>';
    } else {
        echo '<a href="./User/user.php" class="w3-bar-item w3-button"><i class="fa fa-user"></i> USERS</a>'; 
    }
    ?>
        <a href="./Food/food.php" class="w3-bar-item w3-button"><i class="fa fa-glass"></i> FOOD</a>
        <a href="./Food/foodINFO.php" class="w3-bar-item w3-button"><i class="fa fa-heart"></i> FOOD INFO</a>
        <a href="./Meal/meal.php" class="w3-bar-item w3-button"><i class="fa fa-cutlery"></i> MEAL</a>
        <a href="./Meal/mealINFO.php" class="w3-bar-item w3-button"><i class="fa fa-history"></i> MEAL HISTORY</a>
        <a href="./Weight/weight.php" class="w3-bar-item w3-button"><i class="fa fa-area-chart"></i> WEIGHT</a>
        <a href="./Workout/workout.php" class="w3-bar-item w3-button"><i class="fa fa-heartbeat"></i> WORKOUT</a>
      
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
    <a href="./User/user.php" class="w3-bar-item w3-button"><i class="fa fa-user"></i> USERS</a>
    <a href="./Food/food.php" class="w3-bar-item w3-button"><i class="fa fa-glass"></i> FOOD</a>
    <a href="./Food/foodINFO.php" class="w3-bar-item w3-button"><i class="fa fa-heart"></i> FOOD INFO</a>
    <a href="./Meal/meal.php" class="w3-bar-item w3-button"><i class="fa fa-cutlery"></i> MEAL</a>
    <a href="./Meal/mealINFO.php" class="w3-bar-item w3-button"><i class="fa fa-history"></i> MEAL HISTORY</a>
    <a href="./Weight/weight.php" class="w3-bar-item w3-button"><i class="fa fa-area-chart"></i> WEIGHT</a>
    <a href="./Workout/workout.php" class="w3-bar-item w3-button"><i class="fa fa-heartbeat"></i> WORKOUT</a>
</nav>
</html>