<?php
include "db/db_lib.php";
if (check_token("db/base.csv",$_COOKIE["token"])==0){
    setcookie("token","",time()-3600);
    header('Location:/testsite.local/loginform.php');
}
else{
    $username=find_username("db/base.csv",$_COOKIE["token"]);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>SSN|idx</title>
	</head>
	<body>
        <fieldset>
            <p align="center"><?php
    echo "Welcome, ".$username. "!";
}
                ?>
            </p>
            <div align="left">
                <a href="logout.php">Exit</a>
            </div>
        </fieldset>
    </body>
</html>