<?php
include "../Include/connection.php";
include "../Include/randomid.php";

// Search for workout options
function SelectWorkout() {
    $conn = connect();
    $stmt = $conn->prepare("SELECT WorkoutName FROM WorkoutTypes");
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();
    return $result;
}

function SelectHistory($AccountID) {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM WorkoutHistory INNER JOIN WorkoutRoutines ON WorkoutHistory.FKRoutineID = 
                            WorkoutRoutines.RoutineID WHERE FKAccountID = ?;");
    $stmt->bind_param('s', $AccountID);
    $stmt->execute();
    $data = $stmt->get_result();
    $result = $data->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}

function AddWorkout($RoutineID, $RoutineName, $WorkoutName) {
    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO WorkoutRoutines (RoutineID, RoutineName, FKWorkoutName) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $RoutineID, $RoutineName, $WorkoutName);
    $stmt->execute();
    $conn->close();
}

function RoutineFilter($WorkoutName) {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM WorkoutRoutines WHERE FKWorkoutName = ?;");
    $stmt->bind_param('s', $WorkoutName);
    $stmt->execute();
    $data = $stmt->get_result();
    $result = $data->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}

function SelectRoutine() {
    $conn = connect();
    $sql = "SELECT * FROM WorkoutRoutines";
    $data = $conn->query($sql);
    $result = $data->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}

function InsertWorkout($RoutineID, $AccountID, $StartTime, $EndTime, $Intensity, $Calories) {
    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO WorkoutHistory (FKRoutineID, FKAccountID, StartTime, EndTime, Intensity, Calories) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssd', $RoutineID, $AccountID, $StartTime, $EndTime, $Intensity, $Calories);
    $stmt->execute();
    $conn->close();
}

function WorkoutDuration($StartDateTime, $EndDateTime) {
    $StartDateTime = strtotime($StartDateTime);
    $EndDateTime = strtotime($EndDateTime);
    $result = $EndDateTime - $StartDateTime;
    return $result;
}


?>