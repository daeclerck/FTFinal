<html>
<body>
<br><br><br><br>
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

		if(!array_key_exists('MealHistory', $_SESSION)) { 
			$_SESSION['MealHistory'] = array(); 
		}

		if(!array_key_exists('NutrientData', $_SESSION)) { 
			$_SESSION['NutrientData'] = array(); 
		}

		$NutrientTracker = 0;
		$RecommendIntake = 0;

		$RecommendChosen = 0;
    
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			// User fetches Meal History
			if (isset($_POST['FetchHistorySubmit'])) {
				$NewArray = array();

				$_SESSION['MealHistory'] = $NewArray;

				unset($_SESSION['MealHistory']);
				unset($_SESSION['NutrientData']);

				if(!array_key_exists('MealHistory', $_SESSION)) { 
					$_SESSION['MealHistory'] = array(); 
				}

				if(!array_key_exists('NutrientData', $_SESSION)){ 
					$_SESSION['NutrientData'] = array(); 
				}

				$NutrientTracker = 0;
				$RecommendIntake = 0;           
	

				// Get Basic Food Info
				$FoodInfo = array();

				$HistoryStartDate = $_POST['MealStartDate'];
				$HistoryEndDate = $_POST['MealEndDate'];
				$AccountID = $_SESSION['AccountID'];
			
				// Pulls all the necessary information from each table to obtain an accurate calculation
				// on the servings and calories consumed for each meal in the user's meal history
				$Result = sqlGiant($AccountID, "$HistoryStartDate", "$HistoryEndDate");

				foreach($Result as $row) {
					$FoodID = $row["FoodID"];
					$FoodName = $row["FoodName"];
					$ServingsEaten = $row["ServingsEaten"];
					$CaloriesConsumed = $row["CaloriesConsumed"];

					$_SESSION['MealHistory'][$FoodID] = array();

					$_SESSION['MealHistory'][$FoodID]["FoodName"] = $FoodName;
					$_SESSION['MealHistory'][$FoodID]["ServingsEaten"] = $ServingsEaten;
					$_SESSION['MealHistory'][$FoodID]["CaloriesConsumed"] = $CaloriesConsumed;
				}

				// Get Nutrient info using the Food info
				foreach($_SESSION['MealHistory'] as $FoodID => $FoodInfo) {
					$NutrientResult = SelectNutrient($FoodID);

					// Populate array with nutrient info
					foreach ($NutrientResult as $row) {
						$NutrientName = $row['NutrientName'];
						$NutrientType = $row['NutrientType'];

						$DailyIntake = $row['DailyIntake'];
						$PerServing = $row['PerServing'];

						$NutrientConsumed = $_SESSION['MealHistory'][$FoodID]['ServingsEaten'] * $PerServing;

						$_SESSION['MealHistory'][$FoodID][$NutrientName] = array();
						$_SESSION['MealHistory'][$FoodID][$NutrientName]['NutrientName'] = $NutrientName;
						$_SESSION['MealHistory'][$FoodID][$NutrientName]['NutrientType'] = $NutrientType;
						$_SESSION['MealHistory'][$FoodID][$NutrientName]['Consumed'] = $NutrientConsumed;

						if (!array_key_exists($NutrientName, $_SESSION['NutrientData'])) { 
							$_SESSION['NutrientData'][$NutrientName] = array();
				
							$TimeStart = strtotime($HistoryStartDate);
							$TimeEnd = strtotime($HistoryEndDate);
							
							$Seconds = $TimeEnd - $TimeStart;	

							$Days = $Seconds / 86400;
							$TimePeriod = $Days;

							$RecommendIntake = $TimePeriod * $DailyIntake;

							$_SESSION['NutrientData'][$NutrientName]['NutrientType'] = $NutrientType;
							$_SESSION['NutrientData'][$NutrientName]['TotalConsumed'] = $NutrientConsumed;
							$_SESSION['NutrientData'][$NutrientName]['RecommendIntake'] = $RecommendIntake;	
						} 
						else { 
							$_SESSION['NutrientData'][$NutrientName]['TotalConsumed'] += $NutrientConsumed;
						}
					}
				}
			}

			// User submits Nutrient Tracking
			else if (isset($_POST['NutrientUpdateSubmit'])) {	
				$ChosenNutrient = $_POST['NutrientSelector'];
					
				if (array_key_exists($ChosenNutrient, $_SESSION['NutrientData'])) {   
					$NutrientTracker = $_SESSION['NutrientData'][$ChosenNutrient]['TotalConsumed'];   
					$RecommendChosen = $_SESSION['NutrientData'][$ChosenNutrient]['RecommendIntake'];
				}	
			}
		}
	?>

<header class="bgimg-2">
<form method="POST">
	<div class="w3-col m6 w3-center">
    <label>Select Start Date (Inclusive): </label>
    <input type="date" name="MealStartDate">
    <br><label>Select End Date (Inclusive): </label>
    <input type="date" name="MealEndDate">
    <br><input name="FetchHistorySubmit" type="submit" value="Fetch Meal History">
	</div>
	<div class="w3-col m6">
    <table style="border:solid; width:30%;">
    <tr>
        <th>Food Eaten</th>
        <th>Protein</th>
        <th>Carbs</th>
        <th>Fats</th>
        <th>Calories</th>
    </tr>
    <?php 
        foreach($_SESSION['MealHistory'] as $FoodID => $FoodData) {
            echo "<tr>";
                echo "<td>";
				    echo $_SESSION['MealHistory'][$FoodID]['FoodName']; 
				echo "</td>";
                echo "<td>";
                    echo $_SESSION['MealHistory'][$FoodID]['Protein']['Consumed'] . ' ' . 'grams';
                echo "</td>";
                echo "<td>";
                    echo $_SESSION['MealHistory'][$FoodID]['Carbohydrates']['Consumed'] . ' ' . 'grams';
                echo "</td>";
                echo "<td>";
                    echo $_SESSION['MealHistory'][$FoodID]['Fat']['Consumed'] . ' ' . 'grams';
                echo "</td>";
                echo "<td>";
                    echo number_format((float)$_SESSION['MealHistory'][$FoodID]['CaloriesConsumed'], 2, '.', '');
                echo "</td>";
            echo "</tr>";
        }
    ?>
    </table>
	</div>
	<div class="w3-col m4" style="margin-left: 50%;">
	<label>Nutrient Tracker</label>
	<select name="NutrientSelector">
	<option name="Micro1" value="Caffeine"> Caffeine </option>
	<option name="Micro2" value="Vitamin A"> Vitamin A </option>
	<option name="Micro3" value="Vitamin C"> Vitamin C </option>
	<option name="Micro4" value="Vitamin D"> Vitamin D </option>
    </select>
    <input name="NutrientUpdateSubmit" type="submit" value="Track It!" />
    <br>
    <br>
    <label>Amount Consumed (grams) </label>
    <br>
    <input type="text" disabled value=<?php echo $NutrientTracker; ?>>
	<br>
    <label>Amount Recommended (grams) </label>
	<br>
	<input type="text" disabled value=<?php echo $RecommendChosen; ?>>
	</div>
</form>
</header>
</body>
</html>
