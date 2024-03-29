<html>
<body>

    <?php
        // Include SQL methods and header
        include "weightSQL.php";
        include "../header.php";
        
        // Begin session
        if(!isset($_SESSION)) { session_start(); }

        // Send to user page if not selected
        if(empty($_SESSION['AccountID']) || empty($_SESSION['UserName'])) {
            // A user needs to be selected first
            echo "<br><br><br><br><h3 class='w3-center'><b>Please Select A User First!</b><h3>";
            exit();
        }

        if(isset($_POST['NewWeightSubmit']) && !empty($_POST['NewWeight']) && is_numeric($_POST['NewWeight'])) {
            // Fetch the correct date to corresponding weight
            $FetchDate = SelectDate($_POST['WeightChange'], $_SESSION['AccountID']);

            // Update the database with the new weight and send success message
            UpdateWeight($_POST['NewWeight'], $_SESSION['AccountID'], $FetchDate['Recorded']);
        }
    ?>

<header class="bgimg-2">
<h1 class="w3-center title"><b><em>Add Your Current Weight or Change Previous Entries</em></b></h1>
<div class="w3-col m6" style="Padding: 0px 0px 0px 428px;">
    <form method="POST">
        <h1>Update Weight</h1>
        <label>New Weight </label>
        <input type="text" name="Weight">
        <br><label>Unit of Measurement: </label>
        <select name="UnitMeasure">
            <option value="Pounds">Pounds</option>
            <option value="Kilograms">Kilograms</option>
        </select>
        <br><input type="submit" name="WeightSubmit" value="Submit Weight">
    </form>

        <?php
            if(isset($_POST['WeightSubmit']) && !empty($_POST['Weight']) && is_numeric($_POST['Weight'])) {
                $CurrentDate = date("Y-m-d H:i:s");
                AddWeight($_SESSION['AccountID'], $CurrentDate, $_POST['UnitMeasure'], $_POST['Weight']);
                echo "Weight added to " . $_SESSION['UserName'] . "'s account<br>";
                PrintWeight($_SESSION['AccountID']);
            } 
        ?>

</div>
<div class="w3-col m6" style="Padding: 0px 128px 0px 0px;">
<form method="POST">
    <h1>Change Previous Weight</h1>
    <label>Choose the weight to change: </label>
    <select name="WeightChange">

        <?php
            $WeightResult = SelectWeight($_SESSION['AccountID']);

            foreach($WeightResult as $row) {
                echo "<option value='" . $row['CurrentWeight'] . "'>";
                    echo $row['CurrentWeight'] . " " . $row['FKUOMname'] . " Recorded at " . $row['Recorded'];
                echo "</option>";
            }
        ?>

    </select>
    <br><label>Change selected weight to: </label>
    <input type="text" name="NewWeight">
    <br><input type="submit" name="NewWeightSubmit" value="Submit New Weight">
</form>

    <?php
        if(isset($_POST['NewWeightSubmit']) && !empty($_POST['NewWeight']) && is_numeric($_POST['NewWeight'])) {
            echo "Weight updated succesfully!";
            echo "<br>";
            PrintWeight($_SESSION['AccountID']);
        } 
    ?>
    
</div>
</header>
</body>
</html>