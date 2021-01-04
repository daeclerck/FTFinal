<html>
<body>

    <?php
        // Include SQL methods and header
        include "foodSQL.php";
        include "../header.php";

        // Begin session
        if(!isset($_SESSION)) { session_start(); }

        if(!array_key_exists('NutrientArray', $_SESSION)) {   
            $_SESSION['NutrientArray'] = array();  
        }

        if(!array_key_exists('RecommendArray', $_SESSION)) { 	
            $_SESSION['RecommendArray'] = array(); 
        }
        
        if(!array_key_exists('FoodID', $_SESSION)) {   
            $_SESSION['FoodID'] = 0;  
        }

        if(!array_key_exists('ServingSize', $_SESSION)) {   
            $_SESSION['ServingSize'] = 0;  
        }

        if(!array_key_exists('FoodName', $_SESSION)) {   
            $_SESSION['FoodName'] = "''"; 
        }

        if(!array_key_exists('Calories', $_SESSION)) {   
            $_SESSION['Calories'] = 0;  
        }

        if(!array_key_exists('FKUOMname', $_SESSION)) {
            $_SESSION['FKUOMname'] = "Grams";
        }

        $FoodName = $_SESSION['FoodName'];
        $Calories = $_SESSION['Calories'];
        $FoodID = $_SESSION['FoodID'];
        $ServingSize = $_SESSION['ServingSize'];
        $DefaultUnit = "Grams";
        $SelectedUnit = $DefaultUnit;
        $Selector = $DefaultUnit;
        $Conversion = 1;

        if(isset($_POST['ChangeUnitSubmit'])) {
	        $SelectedUnit = $_POST['UnitsSelected'];

            if($SelectedUnit != $_SESSION['FKUOMname']) {
                $UnitsFrom = $_SESSION['FKUOMname'];
                $UnitsTo = $SelectedUnit;

	            $Convert = ConvertUnits($UnitsFrom, $UnitsTo);
	            $ServingSize = floatval($ServingSize) * $Convert['Conversion'];
            }
	
	        $_SESSION['ServingSize'] = $ServingSize;
	        $_SESSION['FKUOMname'] = $SelectedUnit;
        }

        if(isset($_POST['ResetUnitSubmit'])) {
	        $_SESSION['FKUOMname'] = $_SESSION['Reset'];
	        $Reset = ResetUnits($_SESSION['FKUOMname'], $_SESSION['FoodName']);

	        $ResetServing = $Reset['ServingSize'];
	        $DefaultUnit = $Reset['FKUOMname'];
            $ServingSize = $ResetServing;
            $_SESSION['ServingSize'] = $ServingSize;
            $_SESSION['FKUOMname'] = $DefaultUnit;

        }
    ?>

<header class="bgimg-2">
<h1 class="w3-center title"><b><em>Find Nutrient Information For Registered Food</em></b></h1>
<form method="POST">
    <div class="w3-container" style="Padding:16px 64px">
        <div class="w3-col m4"> 
        <label><b>Food Name </b></label>
        <input name="SearchFoodInput" type="text" pattern="^[-a-zA-Z0-9-()]+(\s+[-a-zA-Z0-9-()]+)*$">
        <input name="SearchFoodSubmit" type="submit" value="Search for Food">
        <br><select name="SearchFoodResults">

            <?php
                if(isset($_POST['SearchFoodSubmit'])) {
                    $FoodSearch = $_POST['SearchFoodInput'];
                    $FoodResult = SelectFood($FoodSearch);

                    foreach($FoodResult as $row) {
                        echo "<option value='" . $row['FoodID'] . "'>";
                            echo $row['FoodName'];
                        echo "</option>";
                    }
                }
            ?>

        </select>
        <input name="SelectedFoodSubmit" type="submit" value="Fetch Food Info">



    <?php
        if(isset($_POST['SelectedFoodSubmit']) && !empty($_POST['SearchFoodResults'])) {
            $FoodData = SelectFoodID($_POST['SearchFoodResults']);

            $FoodName = $FoodData["FoodName"];
            $FoodID = $FoodData["FoodID"];
            $ServingSize = $FoodData["ServingSize"];
            $Calories = $FoodData["CalPerServing"];
            $DefaultUnit = $FoodData["FKUOMname"];
            $SelectedUnit = $DefaultUnit;
            $Selector = $DefaultUnit;

            $_SESSION['FoodID'] = $FoodID;
            $_SESSION['ServingSize'] = $ServingSize;
            $_SESSION['FoodName'] = $FoodName;
            $_SESSION['Calories'] = $Calories;
	        $_SESSION['FKUOMname'] = $DefaultUnit;
	        $_SESSION['Reset'] = $DefaultUnit; 
        }
    ?>
    </div>
    <div class="w3-col m4">
    <label>Name </label>
    <select name="FoodDisplay" size="1" disabled>
        <option value="<?php echo $FoodID; ?>">
            <?php echo $FoodName; ?>
        </option>
    </select>
    <br>
    <label>Serving Size </label>
    <input disabled type="number" value="<?php echo $ServingSize; ?>">
    <select name="UnitsSelected">
        <?php
            $SelectData = SelectUOM();
		
            foreach($SelectData as $row) { ?>
	        <option value="<?php echo $row['UOMname']; ?>" <?php if($row['UOMname'] == $_SESSION['FKUOMname']) { echo "selected"; } ?>>
	            <?php echo $row['UOMname']; ?>
    	    </option>
        <?php } ?>
    </select>
    <input name="ChangeUnitSubmit" type="submit" value="Update">
    <input name="ResetUnitSubmit" type="submit" value="Reset">
    <br>
    <label>Calories </label>
    <input disabled type="text" value="<?php echo $Calories; ?>">
    </div>

    <div class="w3-half">
    <table>
        <?php
            if(!empty($FoodID)) {
                $Build = BuildNutrients($FoodID);

                $_SESSION['NutrientArray'] = array();
                foreach($Build as $row) {
                    $NutrientName = $row['NutrientName'];
                    $NutrientQuantity = $row['PerServing'];

                    $_SESSION['NutrientArray'][$NutrientName] = $NutrientQuantity;
                }

                $_SESSION['RecommendArray'] = array();
                foreach($Build as $row) {
                    $RecommendName = $row['NutrientName'];
                    $RecommendDaily = $row['DailyIntake'];

                    $_SESSION['RecommendArray'][$RecommendName] = $RecommendDaily;
                }

                foreach($_SESSION['RecommendArray'] as $NutrientName => $RecommendDaily) {
                    $RecommendArray = $RecommendDaily;
                }
            }
        ?>
        <tr>
        <th>Nutrient Name</th>
        <th>Quantity of Nutrient Per Serving</th>
        <th>Recommended Daily Intake</th>
        </tr>
        <?php 
            foreach($_SESSION['NutrientArray'] as $NutrientName => $Nutrient) {
                echo "<tr>";
                echo "<td>" . $NutrientName . "</td>";
                echo "<td>" . $Nutrient . "</td>";
                foreach($_SESSION['RecommendArray'] as $RecommendName => $RecommendDaily) {
                    if($NutrientName == $RecommendName) {
                        echo "<td>" . $RecommendDaily . "</td>";
                    }
                }
                echo "</tr>";
            }
        ?>
    </table>
    </div>
    </div>
</form>
</header>
</body>
</html>
