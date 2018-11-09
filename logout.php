<?php
include "db/db_lib.php";
if (delete_token("db/base.csv",$_COOKIE["token"])==1){
    setcookie("token","",time()-3600);
    header('Location:/testsite.local/loginform.php');
    }
    else{
        echo "Something in database was wrong! Please, come back later.";
    }
?>