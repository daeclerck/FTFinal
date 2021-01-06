<html>
<body>
<br><br><br><br><br><br><br>
<?php
    // Include SQL methods and header
    include "workoutSQL.php";
    include "../header.php";

    if(!isset($_SESSION)) { session_start(); }

    if(empty($_SESSION['AccountID']) || empty($_SESSION['UserName'])) {
        // A user needs to be selected first
        //header('Location: ../User/user.php');
        $message = "Select a user!";
        header('Refresh: 5; url=../User/user.php');
        exit($message);
    }

    $CurrentUser = $_SESSION['AccountID'];

    $DefaultTime = new DateTime();
    $FormData = array( 'DatetimeWorkout' => $DefaultTime );
	

    if(isset($_POST['RoutineSubmit'])) {
        $Routine = $_POST['RoutineName'];
        $Workout = $_POST['WorkoutType'];

        if($Workout != '' && $Routine != '') {
            $NewWorkout = AddWorkout(RandomID(), $Routine, $Workout);

            echo "<br><br> Data Inserted Successfully!";
        } else {
            echo "<br><br> Insertion Failed <br>Some Fields are empty";
        }
    }

    if(isset($_POST['FilterSubmit'])) {
        $WorkoutFilter = $_POST['WorkoutFilter'];
        $FilterData = RoutineFilter($WorkoutFilter);
    } else {
        $FilterData = SelectRoutine();
    }

    if(isset($_POST['WorkoutSubmit'])) {
        $AccountID = $CurrentUser;
	    $RoutineID = $_POST['RoutineID'];
	    $StartDate = $_POST['StartDateInput'];
	    $StartTime = $_POST['StartTimeInput'];
	    $StartDateTime = date('Y-m-d H:i:s', strtotime($StartDate . ' ' . $StartTime));

	    $EndDate = $_POST['EndDateInput'];
	    $EndTime = $_POST['EndTimeInput'];
	    $EndDateTime = date('Y-m-d H:i:s', strtotime($EndDate . ' ' . $EndTime));

        $Intensity = $_POST['WorkoutIntensity'];
        $Calories = $_POST['CaloriesBurned'];

        $Difference = WorkoutDuration($StartDateTime, $EndDateTime);
        $DifferenceYears = floor($Difference / (365*60*60*24));
        $DifferenceMonths = floor(($Difference - $DifferenceYears * 365*60*60*24) / (30*60*60*24));
        $DifferenceDays = floor(($Difference - $DifferenceYears * 365*60*60*24 - $DifferenceMonths * 30*60*60*24)/ (60*60*24));

        if($Difference <= 0) {
            echo "<br><br> Please enter the correct values into start and end time!";
        }
        else if($DifferenceYears != 0 || $DifferenceMonths != 0 || $DifferenceDays != 0) {
            echo "<br><br> Please enter a workout time within the same day!";
        } else {
            $NewWorkoutHistory = InsertWorkout($RoutineID, $AccountID, $StartDateTime, $EndDateTime, $Intensity, $Calories);
            echo "<br><br> Data Inserted Successfully!";
        }     
    }
?>

<header class="bgimg-2">
<h1 class="w3-center title"><b><em>Workout Template Header</em></b></h1>
<div class="w3-half" style="Padding: 0px 32px 0px 64px;">
<form method="POST">
    <label><b>Insert New Workout </b></label>
    <br>
    <label>Routine Name </label>
    <input name="RoutineName" type="text" pattern="^[-a-zA-Z0-9-()]+(\s+[-a-zA-Z0-9-()]+)*$">
    <br>
    <label>Workout Type </label>
    <select name="WorkoutType">

        <?php
            $WorkoutResult = SelectWorkout();
            foreach($WorkoutResult as $row) {
                echo "<option value='" . $row['WorkoutName'] . "'>";
                    echo $row['WorkoutName'];
                echo "</option>";
            }
        ?>

    </select>
    <input name="RoutineSubmit" type="submit" value="Create Routine">
</form>
</div>

<div class="w3-half" style="Padding: 0px 64px 0px 32px;">
<form method="POST">
<label><b>Log Workout</b></label>
<br><label>Workout Routine </label>
<select name="RoutineID">

    <?php
        foreach($FilterData as $row) {
            echo "<option value='" . $row['RoutineID'] . "'>";
                echo $row['RoutineName'] . "</option>";
        }
    ?>

</select>

<br><label>Start Time </label>
<input name="StartDateInput" type="date" value="<?php echo $FormData['DatetimeWorkout']->format('Y-m-d'); ?>">
<input name="StartTimeInput" type="time" value="<?php echo $FormData['DatetimeWorkout']->format('H:i:s'); ?>" step="1">
<br><label>End Time </label>
<input name="EndDateInput" type="date" value="<?php echo $FormData['DatetimeWorkout']->format('Y-m-d'); ?>">
<input name="EndTimeInput" type="time" value="<?php echo $FormData['DatetimeWorkout']->format('H:i:s'); ?>" step="1">

<br><label>Workout Intensity </label>
<select name="WorkoutIntensity">
    <option value="Calm">Calm</option>
    <option value="Mediocre">Mediocre</option>
    <option value="Moderate">Moderate</option>
    <option value="Intense">Intense</option>
    <option value="Extreme">Extreme</option>
</select>

<br>  
<label>Calories Burned </label>
<input name="CaloriesBurned" type="number" min="0" max="9999" step="1">	
<br>
<input type="submit" name="WorkoutSubmit" value="Log Workout">
</form>
</div>


<div class="w3-half" style="Padding: 0px 32px 0px 64px;">
<form method="POST">
    <label><b>Filter Available Workout Routines</b></label>
    <br>
    <label>Workout Type: </label>
    <select name="WorkoutFilter">
        <?php
            $FilterResult = SelectWorkout();
            foreach($FilterResult as $row) {
                echo "<option value='" . $row['WorkoutName'] . "'>";
                    echo $row['WorkoutName'];
                echo "</option>";
            }
        ?>  
    </select>
    <input name="FilterSubmit" type="submit" value="Filter">
</form>

<h5><b>Available Workout Routines</b></h5>
<table>
<tr>
    <th>Routine Name</th>
    <th>Workout Type</th>
</tr>
<?php
    foreach($FilterData as $row){
      echo "<tr>";
        echo "<td>". $row["RoutineName"] . "</td>";
        echo "<td>" . $row["FKWorkoutName"] . "</td>";
      echo "</tr>";
    }
?>
</table>
</div>



<div class="w3-half" style="Padding: 0px 64px 0px 32px;">
<h5><b>Workout History</b></h5>
<table>
    <tr>
        <th>Routine Name</th>
        <th>Workout Duration</th>
	    <th>Workout Intensity</th>
	    <th>Calories Burned</th>
	</tr>

    <?php
        $FilterData = SelectHistory($CurrentUser);
        foreach($FilterData as $row) {
            $Difference = WorkoutDuration($row['StartTime'], $row['EndTime']);
            $DifferenceHours =  floor($Difference/(60*60));
            $DifferenceMinutes = floor(($Difference - $DifferenceHours*60*60)/ 60);
            $DifferenceSeconds = floor(($Difference - $DifferenceHours*60*60 - $DifferenceMinutes*60));
    
            $Difference = "Hours: " . $DifferenceHours . ", Minutes: " . $DifferenceMinutes . ", Seconds: " . $DifferenceSeconds;

            echo "<tr>";
                echo "<td>" . $row["RoutineName"] . "</td>";
                echo "<td>" . $Difference . "</td>";
                echo "<td>" . $row["Intensity"] . "</td>";
                echo "<td>" . $row["Calories"] . "</td>";
            echo "</tr>";
        }
    ?>
</table>
</div>
</header>
</body>
</html>
