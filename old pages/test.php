<?php  
echo md5('override');
/*
session_start();  
mysql_connect("localhost", "username", "password");  
mysql_select_db("databasename");  

$username=$_SESSION['username'];  
$password=$_SESSION['password'];  

$result=mysql_query("SELECT * FROM logsys WHERE username='$username' AND password='$password'");  
if(mysql_num_rows($result) == 0){ 
    die("Sorry, you are no longer logged in, please login again to continue playing.");  
}else{ 


    if ($edit){ 
     
        echo "editing...<br><br>"; 
         
        if($pass1 != NULL && $pass1 == $pass2) {  
         
            $password = md5($pass1);  
                   
            mysql_query("UPDATE logsys SET password = '". $password ."'") or die("Sorry, password couldn't be changed.");       
            echo "Your password has been updated.<br><br>"; 
         
        } 
         
        $dob = $year . "-" . $month . "-" . $day; 
         
        $sql = "UPDATE logsys SET username = '" . $username . "', email = '" . $email . "', location = '" . $location . "', user_gender = '" . $gender . "', dob = '" . $dob . "'"; 
         
        mysql_query($sql) or die($sql); 
         
        echo"Your profile has been updated.<br><br>"; 

    } 

} 


mysql_connect("localhost", "username", "password");  
mysql_select_db("databasename");  

$username=$_SESSION['username'];  
$password=$_SESSION['password'];  

$result=mysql_query("SELECT * FROM logsys WHERE username='$username' AND password='$password'");  
if(mysql_num_rows($result) == 0){ 

    $userID = mysql_result($result, "0", "logsys.id"); 
    $userUName = mysql_result($result, "0", "logsys.username"); 
    $userLevel = mysql_result($result, "0", "logsys.user_level"); 
    $userEmail = mysql_result($result, "0", "logsys.email"); 
    $userLocation = mysql_result($result, "0", "logsys.location"); 
    $userGender = mysql_result($result, "0", "logsys.gender"); 
    $userDOB = mysql_result($result, "0", "logsys.dob"); 
    $userJoinedDate = mysql_result($result, "0", "logsys.date"); 

    $userDOBYear = $userDOB{0} . $userDOB{1} . $userDOB{2} . $userDOB{3}; 
    $userDOBMonth = $userDOB{5} . $userDOB{6}; 
    $userDOBDay = $userDOB{8} . $userDOB{9}; 

    $userAge = age($userDOB); 

    if ($e == 'TRUE'){ 
        $options = "[ <a href='?ed=1'>edit</a> ]"; 
    } 

    if($ed == 1) { 
        if($userGender == 'Male') { 
            $gender = 'Male'; $othergender = 'Female';
        }else{ 
            $gender = 'Female'; $othergender = 'Male';  
        } 

        ?> 
        <form> 
        <form method="post" action="<?php echo $PHP_SELF?> 
        <table> 
         
          <tr><td>Username:</td><td>  
          <p><input type="text" name="username" value="<?php echo $userUName; ?>"></p></td></tr> 
         
          <tr><td>New Password:</td><td> <p> 
            <input type="password" name="pass1"> 
          </p> 
              </td></tr> 
         
          <tr><td>New Password Again:</td><td> <p> 
            <input type="password" name="pass2"> 
          </p> 
              </td></tr> 
         
          <tr><td>Email:</td><td> <p> 
            <input type="text" name="email" value="<?php echo $userEmail; ?>"> 
          </p> 
              </td></tr> 
         
          <tr><td>Location:</td><td> <p> 
            <input type="text" name="location" value="<?php echo $userLocation; ?>"> 
          </p> 
              </td></tr> 
         
          <tr><td>Gender:</td><td> <p> 
            <select name="gender">  
              <option value="<?php echo $gender; ?>" SELECTED><?php echo $gender; ?>  
                <option value="<?php echo $othergender; ?>"><?php echo $othergender; ?>  
                </select> 
          </p> 
              </td></tr> 
         
          <tr><td>Date of Birth:</td><td>  
         
        <select Name="day"> 
         
        <?php 

        for($i = 0; $i <= 31; $i++) { 
            if($userDOBDay == $i) { 
                $selected = "SELECTED"; 
            } else { 
                $selected = "";  
            } 
            echo"<option value='" . $i . "'" . $selected . ">" . $i . "</option>"; 
        } 

        ?> 
         
        </select> 
         
        <select Name="month"> 
         
        <?php if($userDOBMonth == '01') { $selected = "SELECTED"; } else { $selected = ""; } ?> 
        <option value='01' <?php echo $selected; ?>>January</option> 
        <?php if($userDOBMonth == '02') { $selected = "SELECTED"; } else { $selected = ""; } ?> 
        <option value='02' <?php echo $selected; ?>>February</option> 
        <?php if($userDOBMonth == '03') { $selected = "SELECTED"; } else { $selected = ""; } ?> 
        <option value='03' <?php echo $selected; ?>>March</option> 
        <?php if($userDOBMonth == '04') { $selected = "SELECTED"; } else { $selected = ""; } ?> 
        <option value='04' <?php echo $selected; ?>>April</option> 
        <?php if($userDOBMonth == '05') { $selected = "SELECTED"; } else { $selected = ""; } ?> 
        <option value='05' <?php echo $selected; ?>>May</option> 
        <?php if($userDOBMonth == '06') { $selected = "SELECTED"; } else { $selected = ""; } ?> 
        <option value='06' <?php echo $selected; ?>>June</option> 
        <?php if($userDOBMonth == '07') { $selected = "SELECTED"; } else { $selected = ""; } ?> 
        <option value='07' <?php echo $selected; ?>>July</option> 
        <?php if($userDOBMonth == '08') { $selected = "SELECTED"; } else { $selected = ""; } ?> 
        <option value='08' <?php echo $selected; ?>>August</option> 
        <?php if($userDOBMonth == '09') { $selected = "SELECTED"; } else { $selected = ""; } ?> 
        <option value='09' <?php echo $selected; ?>>September</option> 
        <?php if($userDOBMonth == '10') { $selected = "SELECTED"; } else { $selected = ""; } ?> 
        <option value='10' <?php echo $selected; ?>>October</option> 
        <?php if($userDOBMonth == '11') { $selected = "SELECTED"; } else { $selected = ""; } ?> 
        <option value='11' <?php echo $selected; ?>>November</option> 
        <?php if($userDOBMonth == '12') { $selected = "SELECTED"; } else { $selected = ""; } ?> 
        <option value='12' <?php echo $selected; ?>>December</option> 
        </select> 

        <select Name="year"> 
         
        <?php 
         
        $j = date("Y") - 8; 
        $k = $j - 80; 
         
        for($i = $j; $i > $k; $i--) { 
            if($userDOBYear == $i) { $selected = "SELECTED"; } else { $selected = ""; } 
            echo"<option value='" . $i . "'" . $selected . ">" . $i . "</option>"; 
        } 
         
        ?> 

        </select> 
         
        </td></tr> 
         
          <tr><td><input type="Submit" name="edit" value="Edit"></td><td></td></tr> 
         
        </table> 
         
        </form> 
         
        <?php 

    } else { 

        echo"<table>"; 
        echo "<tr><td><b>" . $userUName . "'s Profile</b></td><td>" . $options . "</td></tr>"; 
        echo "<tr><td>Level:</td><td> " . $userLevel . "</td></tr>"; 
        echo "<tr><td>Name:</td><td> " . $userName . "</td></tr>"; 
        echo "<tr><td>Gender:</td><td> " . $userGender . "</td></tr>"; 
        echo "<tr><td>Email:</td><td> <a href='mailto:" . $userEmail . "'>" . $userEmail . "</a></td></tr>"; 
        echo "<tr><td>Location:</td><td> <a href='http://maps.google.co.uk/?q=" . $userLocation . "'>" . $userLocation . "</a></td></tr>"; 
        echo "<tr><td>Age:</td><td> " . $userAge . "</td></tr>"; 
        echo "<tr><td>Date Joined:</td><td> " . $userJoinedDate . "</td></tr>"; 
        echo"</table>"; 

    } 


}else{ 

    echo "<b>Loading Failed: Invalid UserID. </b><br><br>"; 

} 
  
*/
?> 