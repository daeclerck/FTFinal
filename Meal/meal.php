<html>
<body>

    <?php
        // Include SQL methods and header
        include "mealSQL.php";
        include "../Food/foodSQL.php";
        include "../header.php";

        // Begin session
        if(!isset($_SESSION)) { session_start(); }

        // Send to user page if not selected
        if(empty($_SESSION['AccountID']) || empty($_SESSION['UserName'])) {
            // A user needs to be selected first
            header('Location: ../User/user.php');
        }

        if(!array_key_exists('FoodInMeal', $_SESSION)) {
            $_SESSION['FoodInMeal'] = array();
        }

        $DefaultTime = new DateTime();
        $FormData = array( 'DatetimeEaten' => $DefaultTime );

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // User searching for food
            if(isset($_POST['SearchFoodSubmit'])) {
                $FoodSearch = $_POST['SearchFoodInput'];
            }

            // User adding food to meal
            else if(isset($_POST['AddFoodToMealSubmit']) && !empty($_POST['SearchFoodResult'])) {
                $FoodSearch = $_POST['SearchFoodInput'];

                // Get the new food data
                $FoodID = $_POST['SearchFoodResult'];

                $Result = SelectFoodForMeal($FoodID);

                $FoodName = $Result['FoodName'];
                $FoodQuantity = $_POST['AddFoodQuantity'];
                $FoodUnit = $_POST['UOMSelector'];

                $_SESSION['FoodInMeal'][$FoodID] = [$FoodName, $FoodQuantity, $FoodUnit];
            }

            // User removing a food from meal
            else if(isset($_POST['RemoveFoodSubmit'])) {
                unset($_SESION['FoodInMeal'][$_POST['FoodInMealInput']]);
            }

            // User cleared meal
            else if(isset($_POST['ClearMealSubmit'])) {
                unset($_SESSION['FoodInMeal']);

                if(!array_key_exists('FoodInMeal', $_SESSION)) {
                    $_SESSION['FoodInMeal'] = array();
                }

                $DefaultTime = new DateTime();
                $FormData = array( 'DatetimeEaten' => $DefaultTime );
            }

            // User submitting the meal
            else if(isset($_POST['AddMealSubmit'])) {
                $MealDate = $_POST['DateEatenInput'];
                $MealTime = $_POST['TimeEatenInput'];
                $MealDateTime = date('Y-m-d H:i:s', strtotime($MealDate . ' ' . $MealTime));

                $UserID = $_SESSION['AccountID'];
                $MealID = RandomID();

                // Create new meal
                AddMeal($MealID, $UserID, $MealDateTime);

                // Add food to meal
                foreach($_SESSION['FoodInMeal'] as $key => $value) {
                    // unpack array
                    [$FoodName, $FoodQuantity, $FoodUnit] = $_SESSION['FoodInMeal'][$key];

                    // Query for each food
                    AddFoodForMeal($MealID, $key, $FoodQuantity, $FoodUnit);
                }

                echo "Meal Added Successfully!";
            }

            // Populate/Restore Form Data
            foreach($_POST as $key => $value) {
                if(isset($FormData[$key])) {
                    $FormData[$key] = htmlspecialchars($value);
                }
            }
        }
    ?>

<header class="bgimg-2">
<h1 class="w3-center title"><b><em>Add Food To Meals Throughout The Day</em></b></h1>
<form method="POST">
<div class="w3-half" style="Padding:0px 32px">
    <label>Food Name </label>
    <input name="SearchFoodInput" type="text" pattern="^[-a-zA-Z0-9-()]+(\s+[-a-zA-Z0-9-()]+)*$">
    <input name="SearchFoodSubmit" type="submit" value="Search For Food">
    <br><label style="Margin-bottom: 50px; display:inline-block;">Search Results </label>
    <br><select name="SearchFoodResult" size="10" style="height:15%; width:40%;">

        <?php
            if(isset($_POST['SearchFoodSubmit']) || isset($_POST['AddFoodToMealSubmit'])) {
                $FoodResult = SelectFood($FoodSearch);

                foreach($FoodResult as $row) {
                    echo "<option value='" . $row['FoodID'] . "'>";
                        echo $row['FoodName'];
                    echo "</option>";
                }
            }
        ?>

    </select>
    <br><label>Amount Eaten </label>
    <input name="AddFoodQuantity" type="number" min="0" max="999" value="0">
    <select name="UOMSelector" size="1">
        <?php
            $UnitData = SelectUOM();

            foreach($UnitData as $row) {
                echo "<option value='" . $row['UOMname'] . "'>";
                    echo $row['UOMname'];
                echo "</option>";
            }
        ?>
    </select>
    <br>
    <br><input name="AddFoodToMealSubmit" type="submit" value="Add Food To Meal">
</div>
<div class="w3-half">
    <select name="FoodInMealInput" size="10" style="height:15%; width:40%;">

        <?php
            foreach($_SESSION['FoodInMeal'] as $key => $value) {
                [$FoodName, $FoodQuantity, $FoodUnit] = $_SESSION['FoodInMeal'][$key];

                echo "<option value='" . $key . "'>";
                    echo $FoodName . ": " . $FoodQuantity . " " . $FoodUnit;
                echo "</option>";
            }
        ?>

    </select>
    <br><label>Date Meal was Eaten </label>
    <input name="DateEatenInput" type="date" value="<?php echo $FormData['DatetimeEaten']->format('Y-m-d'); ?>">

    <br><label>Time Meal was Eaten </label>
    <input name="TimeEatenInput" type="time" value="<?php echo $FormData['DatetimeEaten']->format('H:i:s'); ?>" step="1">
    <br><input name="RemoveFoodSubmit" type="submit" value="Remove From Meal">
    <input name="ClearMealSubmit" type="submit" value="Clear Meal">
    <br><input class="w3-button w3-black" name="AddMealSubmit" type="submit" value="Add This Meal">
</div>


</form>
</header>
</body>
</html>