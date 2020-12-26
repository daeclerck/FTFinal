<?php

// Select the specific name that matches the unique ID
function SelectFoodForMeal($FoodID) {
    $conn = connect();
    $stmt = $conn->prepare("SELECT FoodName FROM Food WHERE FoodID = ?");
    $stmt->bind_param('s', $FoodID);
    $stmt->execute();
    $data = $stmt->get_result();
    $result = $data->fetch_array(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}

// Add complete meal to the database
function AddMeal($MealID, $AccountID, $Date) {
    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO Meal (MealID, FKAccountID, TimeEaten) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $MealID, $AccountID, $Date);
    $stmt->execute();
    $conn->close();
}

// Add each food into specific meal
function AddFoodForMeal($MealID, $FoodID, $Servings, $UOMname) {
    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO FoodInMeal (FKMealID, FKFoodID, Servings, FKUOMname) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssds', $MealID, $FoodID, $Servings, $UOMname);
    $stmt->execute();
    $conn->close();  
}

// Comprehensive table of added nutrients and calories in 
function sqlGiant($Account, $StartDate, $EndDate) {
    $conn = connect();
    $stmt = $conn->prepare("SELECT FoodID, FoodName, ServingsEaten, SUM(CalPerServing * ServingsEaten) AS
                            CaloriesConsumed FROM ( SELECT FoodID, FoodName, SUM( ( FoodEatenQuantity * ( SELECT
                            MAX(Conversion) FROM UnitConversion WHERE FKUnitFrom = FoodData.FoodEatenUnit
                            AND FKUnitTo = FoodData.FoodUnit ) ) / (ServingSize) ) AS ServingsEaten, CalPerServing
                            FROM ( SELECT Food.FoodID, Food.FoodName, Food.ServingSize, Food.FKUOMname AS
                            FoodUnit, Food.CalPerServing, FoodInMeal.Servings AS FoodEatenQuantity,
                            FoodInMeal.FKUOMname AS FoodEatenUnit FROM Meal
                            INNER JOIN FoodInMeal ON Meal.MealID = FoodInMeal.FKMealID INNER JOIN Food ON
                            Food.FoodID = FoodInMeal.FKFoodID WHERE Meal.FKAccountID = ?
                            AND Meal.TimeEaten BETWEEN ? AND ? ) AS FoodData GROUP BY FoodID, FoodUnit )
                            AS FoodInfo GROUP BY FoodID;");
    $stmt->bind_param('sss', $Account, $StartDate, $EndDate);
    $stmt->execute();
    $data = $stmt->get_result();
    $result = $data->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}

// Fetch nutrient information to display for user
function SelectNutrient($FoodID) {
    $conn = connect();
    $stmt = $conn->prepare("SELECT NutrientName, NutrientType, PerServing, DailyIntake
                            FROM FoodNutrients INNER JOIN Nutrients ON Nutrients.NutrientName = FoodNutrients.FKNutrientName
                            WHERE FoodNutrients.FKFoodID = ?;");
    $stmt->bind_param('s', $FoodID);
    $stmt->execute();
    $data = $stmt->get_result();
    $result = $data->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}
?>
