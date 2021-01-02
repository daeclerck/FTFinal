<html>
<body>
<?php 
    include "userSQL.php";
    include "../header.php";

    $DeleteSuccess = False;
 
    if(!isset($_SESSION)) { session_start(); }

    if(isset($_POST['DeleteUser']) && !empty($_POST['DeleteID'])) {
        // Remove the chosen AccountID and delete from database
	    $delete = $_POST['DeleteID'];
        DeleteUser($delete);
        $DeleteSuccess = True;	
    } 
?>
<header class="bgimg-2">
<h1 class="w3-center" style="Padding:80px"><b><em>Begin tracking your fitness today</em></b></h1>
<div class="w3-container" style="Padding:0px 32px">
    <div class="w3-row-padding">
        <div class="w3-col m5">
            <form method="POST">
                <h1><i class="fa fa-plus w3-xxlarge"></i> Add a User</h1>
                <!-- Check for valid user names including no white spaces in beginning or end -->
                <input type="text" name="UserName" required pattern="^[-a-zA-Z0-9-()]+(\s+[-a-zA-Z0-9-()]+)*$" title="This field is required" placeholder="Enter Valid Name">
                <input type="submit" name="UserNameSubmit" value="Add User"> 
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
?>  
        </div>
        <div class="w3-col m5">
            <form method="POST">   
                <h1><i class="fa fa-mouse-pointer w3-xxlarge"></i> Select a User</h1>
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
                <h1><i class="fa fa-times w3-xxlarge"></i> Delete a User</h1> 
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
    if($DeleteSuccess) {
        // Print message on success
        echo "User successfully removed!";
    }  
?>
        </div>
    </div>
</div>

</header>  
</body>
</html>
