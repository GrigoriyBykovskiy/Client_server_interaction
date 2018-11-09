<?php
include "db/db_lib.php";
if (!isset($_COOKIE["token"])) {
    if (isset($_POST["login"])&&isset($_POST["password"])){
        $password_hash=create_password_hash($_POST["password"]);
        if (check_log_and_pass("db/base.csv",$_POST["login"],$password_hash)==1){
            $token=create_token();
            if (write_token("db/base.csv",$_POST["login"],$password_hash,$token)==1){
                setcookie ("token", $token);
                header('Location:/testsite.local/index.php');
            }
            else{
                echo "Something in database was wrong! Please, come back later.";
            }
        }
        else {
            echo "Access denied! Check your login/password.";
        }
    }
}
    else{
        header('Location:/testsite.local/index.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>SSN|gate</title>
	</head>
	<body>
		<form method="post" >
            <fieldset>
                <legend>Authorization</legend>
                <div align="center">
			/*Use regular expressions for validate(not use _\. first symbol must be a char)*/
                <p><input id="login" name="login" type="text" placeholder="username" maxlength="10" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,}$" required></p>
                    </div>
                <div align="center">
			/*Use regular expressions for validate(not use _\. && use lowercase and uppercase letters, numbers)*/
                <p><input id="password" name="password" type="password" placeholder="password" maxlength="15" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{4,}$" required></p>
                    </div>
                <div align="center">
                    <button type="submit">login</button>
                </div>
                <div align="left">
                    <a href="registerform.php">Registration</a>
                </div>
            </fieldset>
        </form>
	</body>
</html>
