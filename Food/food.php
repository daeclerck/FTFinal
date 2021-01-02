<?php include "../header.php"; ?>
<html>
<body>
<header class="bgimg-2">
<br><br><br>
<?php
    include "foodSQL.php";

    if(!isset($_SESSION)) { session_start(); }

    $AlreadyStored = False;

?>

<?php
    // Hold nutrient info
    if(!array_key_exists('NutrientValueArray', $_SESSION)) {
        $_SESSION["NutrientValueArray"] = array();

        // Initialize micronutrients
        $MicroData = SelectMicro();
        foreach($MicroData as $key) {
            $_SESSION["NutrientValueArray"][$key["NutrientName"]] = 0;
        }
    }

    // Initialize food info
    $FoodInfo = array('FoodNameInput' => '',
                      'ServingSizeInput' => 0,
                      'ServingSizeUOM' => 'Grams',
                      'CaloriesInput' => 0,
                      'FatInput' => 0,
                      'CarbsInput' => 0,
                      'ProteinInput' => 0);
?>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // If the user submitted the form, process it
	if(isset($_POST['NewFoodSubmit']) && !empty($_POST['FoodNameInput'])) {

            // Food Info
            $FoodName = $_POST['FoodNameInput'];
            $SizeUOM = $_POST['ServingSizeUOM'];
            $ServingSize = $_POST['ServingSizeInput'];
            $Calories = $_POST['CaloriesInput'];
            $FoodID = RandomID();

            AddFood($FoodID, $FoodName, $SizeUOM, $ServingSize, $Calories);

            // Nutrient Info
            $UOMname = "Grams"; // Hard coded as grams

            $MacroArray = array();
            $MacroArray['Fat'] = $_POST['FatInput'];
            $MacroArray['Carbohydrates'] = $_POST['CarbsInput'];
            $MacroArray['Protein'] = $_POST['ProteinInput'];

            // Insert amounts into Food Nutrient table
            foreach($MacroArray as $key => $value) {
                AddNutrients($key, $FoodID, $SizeUOM, $value);
            }

            foreach($_SESSION["NutrientValueArray"] as $key => $value) {
                // Only commit micros if they have a value above zero
                if($value > 0) {
                    AddNutrients($key, $FoodID, $SizeUOM, $value);
                }
	        }   

	    // Reset the micronutrient array
        $MicroReset = SelectMicro();
        foreach($MicroReset as $key) {
            $_SESSION["NutrientValueArray"][$key["NutrientName"]] = 0;
	    }	    
	    
    }

	else if(isset($_POST['MicroSubmit']) && !empty($_POST['MicroSelect'])) {
	    // Retain the values in the form
	    $FoodInfo['FoodNameInput'] = $_POST['FoodNameInput'];
	    $FoodInfo['CaloriesInput'] = $_POST['CaloriesInput'];
	    $FoodInfo['ServingSizeInput'] = $_POST['ServingSizeInput'];
	    $FoodInfo['FatInput'] = $_POST['FatInput'];
	    $FoodInfo['CarbsInput'] = $_POST['CarbsInput'];
	    $FoodInfo['ProteinInput'] = $_POST['ProteinInput'];
	    
        $key = $_POST['MicroSelect'];
        $value = $_POST['MicroInput'];

	    $_SESSION["NutrientValueArray"]["$key"] = $value;
    }
    
    else if(isset($_POST['DeleteFoodSubmit'])) {
        
        if(DeleteFoodConfirm($_POST['DeleteFood'])) {
            DeleteFood($_POST['DeleteFood']);
            echo "Food Deleted Successfully.";
        }
        else { $AlreadyStored = True; }
    }
}
?>
<h1 class="w3-center" style="Padding:8px"><b><em>Add Your Favorite Foods Here</em></b></h1>
<div class="w3-container" style="Padding:32px 64px">

<div class="w3-col m6 w3-left-align" style="Padding:16px 128px"> 
<form method="POST">
    <label><b>Food Name </b></label>
    <!-- Check for valid food names including no white spaces in beginning or end -->
    <input name="FoodNameInput" type="text" value="<?php echo $FoodInfo['FoodNameInput']; ?>" pattern="^[-a-zA-Z0-9-()]+(\s+[-a-zA-Z0-9-()]+)*$" 
        title="This field is required" placeholder="Enter Valid Name">
    <br>
    <label><b>Serving Size </b></label>
    <input class="w3-right-align" name="ServingSizeInput" type="number" value="<?php echo $FoodInfo['ServingSizeInput']; ?>" min="0" max="999.99" step="0.01">
    <select name="ServingSizeUOM">
        <?php 
            $Selector = $FoodInfo['ServingSizeUOM'];
            $UOMdata = SelectUOM();
            
            // Start Unit of Measurement on Grams
            foreach($UOMdata as $row) {
                if($row["UOMname"] == $Selector) {
                    echo "<option selected='selected' value=" . $row['UOMname'] . ">";
                        echo $row['UOMname'];
                    echo "</option>";
                } else {
                    echo "<option value=" . $row['UOMname'] . ">";
                        echo $row['UOMname'];
                    echo "</option>";
                }
            }
            
        ?>
    </select>

    <!-- Macronutrients -->
    <br><label><b>Calories per Serving </b></label>
    <input class="w3-right-align" name="CaloriesInput" type="number" min="0" max="99999" value="<?php echo $FoodInfo['CaloriesInput']; ?>">   
    <br>
    <label><b>Fat per Serving </b></label>
    <input class="w3-right-align" name="FatInput" type="number" min="0" max="99999" value="<?php echo $FoodInfo['FatInput']; ?>">
    <br>
    <label><b>Carbs per Serving </b></label>
    <input class="w3-right-align" name="CarbsInput" type="number" min="0" max="99999" value="<?php echo $FoodInfo['CarbsInput']; ?>">
    <br>
    <label><b>Protein per Serving </b></label>
    <input class="w3-right-align" name="ProteinInput" type="number" min="0" max="99999" value="<?php echo $FoodInfo['ProteinInput']; ?>">
    <br>
    <h6><em>Calories / Fat / Carbs / Protein <b>must</b> be in grams!</em></h6>
    <input class="w3-button w3-black" name="NewFoodSubmit" type="submit" value="Add New Food">

</div>

<div class="w3-col m6 w3-left-align" style="Padding:16px 0px" id="test">
    <!-- Micronutrients -->
    <label><b>Micronutrient</b></label>
    <select name="MicroSelect">
        <?php
	    $MicroChart = SelectMicro();
	    foreach($MicroChart as $row) {
                $key = $row["NutrientName"];
                $value = $_SESSION["NutrientValueArray"][$key];
                echo "<option value='" . $key . "'>" . $key . ": " . $value . "</option>"; 
            }
        ?>
    </select><br>
    <label><b>Quantity</b></label>
    <input class="w3-right-align" name="MicroInput" type="number" oninput='precise(this)' min="0" max="99999" value="0" step="0.00000001">
    <br><h6><em>Micronutrients <b>must</b> be in grams!</em></h6>
    <input name="MicroSubmit" type="submit" value="Add/Update Micronutrient"><br><br><br>

    <label><b>Choose a food to delete</b></label>
    <select name="DeleteFood">
    <option disabled selected value> -- select a food -- </option>
        <?php 
            $DeleteFood = DeleteFoodSelect();
            
            // Start Unit of Measurement on Grams
            foreach($DeleteFood as $row) {
                echo "<option value=" . $row['FoodID'] . ">";
                    echo $row['FoodName'];
                echo "</option>";
            } 
        ?>
    </select>
    <br>
    <input name="DeleteFoodSubmit" type="submit" value="Delete Food">
    <?php if($AlreadyStored) { echo "That food is stored in a meal!"; } ?>
    <br><h6><b>NOTE:</b><em> Food already in a user's meal can not be removed!</em></h6>
</div>

</div>

<!-- Script to remove scientific notation -->
<script>
  function precise(elem) {
    elem.value = Number(elem.value).toFixed(8);
  }
</script>

</form>
</header>
</body>
</html>
