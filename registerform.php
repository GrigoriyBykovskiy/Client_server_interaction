<?php
include "db/db_lib.php";
if (isset($_POST["login"])&&isset($_POST["password"])&&isset($_POST["repeat_password"])){
    if (check_login("db/base.csv",$_POST["login"])==0){
        if ($_POST["password"]==$_POST["repeat_password"]) {
            $password_hash=create_password_hash($_POST["password"]);
            if (write_login_and_pass("db/base.csv",$_POST["login"],$password_hash)){
                $token=create_token();
                if (write_token("db/base.csv",$_POST["login"],$password_hash,$token)==1){
                    setcookie ("token", $token);
                    header('Location:/testsite.local/index.php');
                }
                else{
                    echo "Something in database was wrong! Please, come back later.";
                }
            }
            else{
                echo "Something in database was wrong! Please, come back later.";
            }
        }
        else{
            echo "Check fields password and repeat password!";
        }
    }
    else{
        echo "User with the same login already exists!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>SSN|reg</title>
	</head>
	<body>
		<form action="registerform.php" method="post" >
            <fieldset>
                <legend>Registration</legend>
                <div align="center">
                    <?php
                        /*Use regular expressions for validate(not use _\. first symbol must be a char)*/
                    ?>
                <p><input id="login" name="login" type="text" placeholder="username" maxlength="10" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,}$" required></p>
                    </div>
                <div align="center">
                    <?php
                        /*Use regular expressions for validate(not use _\. && use lowercase and uppercase letters, numbers)*/
                    ?>
                <p><input id="password" name="password" type="password" placeholder="password" maxlength="15" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{4,}$" required ></p>
                    </div>
                <div align="center">
                <p><input id="repeat_password" name="repeat_password" type="password" placeholder="repeat password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{4,}$" required ></p>
                    </div>
                <div align="center">
                    <button type="submit">OK</button>
                </div>
            </fieldset>
        </form>
	</body>
</html>
