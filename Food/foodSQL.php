<?php
include "../Include/connection.php";
include "../Include/randomid.php";

// Search for food with any similarity to user input
function SelectFood($FoodName) {
    $conn = connect();
    $FoodNameFinal = "%$FoodName%";
    $stmt = $conn->prepare("SELECT * FROM Food WHERE FoodName LIKE ?");
    $stmt->bind_param('s', $FoodNameFinal);
    $stmt->execute();
    $data = $stmt->get_result();
    $result = $data->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}

// Reset unit of measurements to match original measurement
function ResetUnits($FKUOMname, $FoodName) {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM Food WHERE FKUOMname = ? AND FoodName = ?");
    $stmt->bind_param('ss', $FKUOMname, $FoodName);
    $stmt->execute();
    $data = $stmt->get_result();
    $result = $data->fetch_array(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}

// Fetch all food information using unique ID
function SelectFoodID($FoodData) {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM Food WHERE FoodID = ?");
    $stmt->bind_param('s', $FoodData);
    $stmt->execute();
    $data = $stmt->get_result();
    $result = $data->fetch_array(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}

// Fetch all micronutrients for options menu
function SelectMicro () {
    $conn = connect();
    $stmt = $conn->prepare("SELECT NutrientName FROM Nutrients WHERE NutrientType = \"Micronutrient\"");
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();
    return $result;
}

// Fetch all unit of measurements
function SelectUOM() {
    $conn = connect();
    $stmt = $conn->prepare("SELECT UOMname FROM UnitsOfMeasurement");
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();
    return $result;
}

// Add food to the database
function AddFood($FoodID, $FoodName, $FKUOMname, $ServingSize, $CalPerServing) {
    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO Food (FoodID, FoodName, FKUOMname, ServingSize, CalPerServing) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssdd', $FoodID, $FoodName, $FKUOMname, $ServingSize, $CalPerServing);
    $stmt->execute();
    $conn->close();
}

// Delete food from each table in database
function DeleteFood($FoodID) {
    $conn = connect();
    $stmt = $conn->prepare("DELETE FROM Food WHERE FoodID = ?");
    $stmt->bind_param('s', $FoodID);
    $stmt->execute();
    $conn->close();
}

// Fetch food for user selection
function DeleteFoodSelect() {
    $conn = connect();
    $sql = "SELECT * FROM Food";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

// Confirm deleting a food
function DeleteFoodConfirm($FoodID) {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM FoodInMeal WHERE FKFoodID = ?");
    $stmt->bind_param('s', $FoodID);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();

    if(mysqli_num_rows($result) == 0) {
        $bool = true;
    } else {
        $bool = false;
    }

    return $bool;  
}

// Add nutrients provided by the food to database
function AddNutrients($NutrientName, $FoodID, $FKUOMname, $Quantity) {
    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO FoodNutrients (FKNutrientName, FKFoodID, FKUOMname, PerServing) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('sssd', $NutrientName, $FoodID, $FKUOMname, $Quantity);
    $stmt->execute();
    $conn->close();
}

// Convert units to display other measurement details
function ConvertUnits($UnitsFrom, $UnitsTo) {
    $conn = connect();
    $stmt = $conn->prepare("SELECT Conversion FROM UnitConversion WHERE FKUnitFrom = ? AND FKUnitTo = ?");
    $stmt->bind_param('ss', $UnitsFrom, $UnitsTo);
    $stmt->execute();
    $data = $stmt->get_result();
    $result = $data->fetch_array(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}

// Fetch all important nutrient information for selected food
function BuildNutrients($FoodID) {
    $conn = connect();
    $stmt = $conn->prepare("SELECT NutrientName, DailyIntake, PerServing FROM Food
                            INNER JOIN FoodNutrients ON FoodNutrients.FKFoodID = ?
                            INNER JOIN Nutrients ON Nutrients.NutrientName = FoodNutrients.FKNutrientName");
    $stmt->bind_param('s', $FoodID);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();
    return $result;
}
?>
