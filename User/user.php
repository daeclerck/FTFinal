<html>
<body>
<?php 
    include "userSQL.php";
    include "../header.php";
 
    if(!isset($_SESSION)) { session_start(); }
?>
<br>
<header class="bgimg-2">
<div class="w3-container" style="Padding:176 32px">
<h3 class="w3-center">Get started by selecting a user</h3>
    <div class="w3-row-padding">
        <div class="w3-col m5">
            <form method="POST">
                <h1>Add a User</h1>
                <label>User Name: </label>
                <!-- Check for valid user names including no white spaces in beginning or end -->
                <input type="text" name="UserName" required pattern="^[-a-zA-Z0-9-()]+(\s+[-a-zA-Z0-9-()]+)*$" title="This field is required" placeholder="Enter Valid Name">
                <input type="submit" name="UserNameSubmit" value="Add User"> 
            </form> 
        </div>
<?php
    if(isset($_POST['UserNameSubmit']) && !empty($_POST['UserName'])) {
        // Add a new user with a randomly generated ID
        $NewUser = AddUser(RandomID(), $_POST['UserName']);
        echo $_POST['UserName'] . " was successfully added!";
    } 
    else if(isset($_POST['UserNameSubmit']) && empty($_POST['UserName'])) { 
        echo "Username can not be empty!"; 
    }
?>  

        <div class="w3-col m5">
            <form method="POST">   
                <h1>Select a User</h1>
                <select name="AccountID">
                <option disabled selected value> -- select a user -- </option>
                <?php
                    $account = SelectUser();
                    foreach($account as $result) {
                        echo "<option value='" . $result['AccountID'] . "'>" . $result['UserName'] . "</option>";
                    }    
                ?>  
                </select>
                <input type="submit" name="ViewOptions" value="Select User"> 
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
        </div>
        <div class="w3-col m2">
            <form method="POST">
                <h1>Delete a User</h1> <i class="fa fa-times"></i>
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
        </div>
<?php
    if(isset($_POST['DeleteUser']) && !empty($_POST['DeleteID'])) {
        // Remove the chosen AccountID and delete from database
	    $delete = $_POST['DeleteID'];
        DeleteUser($delete);
        
	    // Refresh the page to update the options
        header('Location: user.php');	
    }  
?>
    </div>
</div>

</header>  
</body>
</html>
