<?php
    include "../Include/connection.php";
    include "../Include/randomid.php";

    // Grab all content from user table
    function SelectUser() {
        $conn = connect();
        $sql = "SELECT * FROM User ORDER BY UserName";
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

    // Grab specific user from user table
    function ConfirmUser($AccountID) {
        $conn = connect();
        $stmt = $conn->prepare("SELECT * FROM User WHERE AccountID = ?");
        $stmt->bind_param('s', $AccountID);
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        while($row = $result->fetch_assoc()) {
            return $row['UserName'];
        }
    }

    // Add new user into user table
    function AddUser($AccountID, $UserName) {
        $conn = connect();
        $stmt = $conn->prepare("INSERT INTO User (AccountID, UserName) VALUES (?, ?)");
        $stmt->bind_param('ss', $AccountID, $UserName);
        $stmt->execute();
        $conn->close();
    }

    // Delete user from user table
    function DeleteUser($AccountID) {
        $conn = connect();
        $stmt = $conn->prepare("DELETE FROM User WHERE AccountID = ?");
        $stmt->bind_param('s', $AccountID);
        $stmt->execute();
        $conn->close();
    }

    // Print entire user table
    function PrintUser() {
        $result = SelectUser();
        
        if($result->num_rows > 0) {
            echo "<table border>";
                echo "<tr>";
                echo "<th>Account ID</th><th>User Name</th>";
            echo "</tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                    echo "<td>" . $row['AccountID'] . "</td>";
                    echo "<td>" . $row['UserName'] . "</td>";
            }
            echo "</tr>";
            echo "</table>";
        }
    }
?>
