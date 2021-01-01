<html>
<body>
<?php 
    include "userSQL.php";
    include "../header.php";
 
    if(!isset($_SESSION)) { session_start(); }
?>
<br>
<header class="bgimg-2">
<form method="POST">
    <div class="w3-container w3-light-grey w3-padding-64">
    <h1>Add a new User</h1>
    <label>User Name: </label>
    <!-- Check for valid user names including no white spaces in beginning or end -->
    <input type="text" name="UserName" required pattern="^[-a-zA-Z0-9-()]+(\s+[-a-zA-Z0-9-()]+)*$" title="This field is required">
    <input type="submit" name="UserNameSubmit" value="Add User"> 
    </div>
</form> 

<?php
    if(isset($_POST['UserNameSubmit']) && !empty($_POST['UserName'])) {
        // Add a new user with a randomly generated ID
        $NewUser = AddUser(RandomID(), $_POST['UserName']);
        echo $_POST['UserName'] . " was successfully added!";
    } 
    else if(isset($_POST['UserNameSubmit']) && empty($_POST['UserName'])) { 
        echo "Username can not be empty!"; 
    }
    else { echo "Please enter a valid name."; }
?>  

<form method="POST">   
    <h1>Select a Registered User from the list below</h1>
    <select name="AccountID">
    <option disabled selected value> -- select a user -- </option>
    <?php
        $account = SelectUser();
        foreach($account as $result) {
            echo "<option value='" . $result['AccountID'] . "'>" . $result['UserName'] . "</option>";
        }    
    ?>  
    </select>
    <input type="submit" name="ViewOptions" value="View Options"> 
</form>    

<?php
    if(isset($_POST['ViewOptions']) && !empty($_POST['AccountID'])) {
        $confirm = $_POST['AccountID'];
        // Set the Session to the chosen user
        $_SESSION['AccountID'] = $confirm;
        $_SESSION['UserName'] = ConfirmUser($confirm);

	    // Display success message with selected user
        echo ConfirmUser($confirm) . " has been selected!";
    }  
?>

<form method="POST">
    <h1>Select a Registered User to delete</h1>
    <select name="DeleteID">
    <option disabled selected value> -- select a user -- </option>
    <?php
        $account = SelectUser();
        foreach($account as $result) {
            echo "<option value='" . $result['AccountID'] . "'>" . $result['UserName'] . "</option>";
        }    
    ?>  
    </select>
    <input type="submit" name="DeleteUser" value="Delete User">   
</form>    

<?php
    if(isset($_POST['DeleteUser']) && !empty($_POST['DeleteID'])) {
        // Remove the chosen AccountID and delete from database
	    $delete = $_POST['DeleteID'];
        DeleteUser($delete);
        
	    // Refresh the page to update the options
        header('Location: user.php');	
    }  
?>

</header>  
</body>
</html>
