<?php
include "../Include/connection.php";
include "../Include/randomid.php"; // May not need this

// Select the currect weight info for selected user
function SelectWeight($AccountID) {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM Weight WHERE FKAccountID = ?");
    $stmt->bind_param('s', $AccountID);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();
    return $result;
}

// Addd newly recorded weight to database
function AddWeight($AccountID, $Date, $Unit, $Weight) {
    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO Weight (FKAccountID, Recorded, FKUOMname, CurrentWeight) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('sssd', $AccountID, $Date, $Unit, $Weight);
    $stmt->execute();
    $conn->close();
}

// Change existing weight to new weight
function UpdateWeight($Weight, $AccountID, $Date) {
    $conn = connect();
    $stmt = conn->prepare("UPDATE Weight SET CurrentWeight = ? WHERE FKAccountID = ? AND Recorded = ?");
    $stmt->bind_param('dss', $Weight, $AccountID, $Date);
    $stmt->execute();
    $conn->close();
}

// Print weight table for selected user
function PrintWeight($AccountID) {
    $result = SelectWeight($AccountID);
    
    if($result->num_rows > 0) {
        echo "<table border>";
            echo "<tr>";
            echo "<th>Weight</th>";
            echo "<th>Date Recorded</th>";
        echo "</tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
                echo "<td>" . $row['CurrentWeight'] . " " . $row['FKUOMname'] . "</td>";
                echo "<td>" . $row['Recorded'] . "</td>";
        }
        echo "</tr>";
        echo "</table>";
    }
}

?>
