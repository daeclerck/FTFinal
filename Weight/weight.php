<html>
<body>

<?php 
    include "weightSQL.php"; 
    
    if(!isset($_SESSION)) { session_start(); }

    if(empty($_SESSION['AccountID']) || empty($_SESSION['UserName'])) {
        // A user needs to be selected first
        header('Location: ../User/user.php');
        //exit("Sorry, the current session has expired. Please log in again.");
    }
?>

<form method="POST">
    <h1>Update Weight</h1>
    <label>New Weight: </label>
    <input type="text" name="Weight"/>
    <label>Unit of Measurement: </label>
    <select name="UnitMeasure">
        <option value="Pounds">Pounds</option>
        <option value="Kilograms">Kilograms</option>
    </select>
    <input type="submit" name="WeightSubmit" value="Submit Weight"/>
</form>

<?php
    if(isset($_POST['WeightSubmit'])) {
        $CurrentDate = date("Y-m-d H:i:s");
        AddWeight($_SESSION['AccountID'], $CurrentDate, $_POST['UnitMeasure'], $_POST['Weight']);
        echo "Weight added to " . $_SESSION['UserName'] . "'s account<br>";
        PrintWeight($_SESSION['AccountID']);
    }
?>


</body>
</html>