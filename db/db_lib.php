<?php
function check_token($filename,$token){
    $base = fopen($filename, 'r');
    while ($line = fgetcsv($base)) {
        if (isset($line[2])) {
            if ($line[2]== $token){
                fclose($base);
                return 1;
            }
        }
    }
    fclose($base);
    return 0;
}
function check_log_and_pass($filename,$login,$password){
    $base = fopen($filename, 'r');
    while ($line = fgetcsv($base)) {
        if ($line[0] == $login && $line[1]==$password) {
            return 1;
        }
    }
    fclose($base);
    return 0;
}
function check_login($filename,$login){
    $base = fopen($filename, 'r');
    while ($line = fgetcsv($base)) {
        if ($line[0] == $login) {
            return 1;
        }
    }
    fclose($base);
    return 0;
}
function find_username($filename,$token){//return username or NULL
    $base = fopen($filename, 'r');
    while ($line = fgetcsv($base)) {
        if (isset($line[2])) {
            if ($line[2]== $token){
                fclose($base);
                return $line[0];
            }
        }
    }
    return NULL;
}
function write_token($filename,$login,$password,$token){//security warning:This function may be unsafe
    $append_data=array($login,$password,$token);
    $lines_base=file($filename);//split the base into lines
    $base=fopen($filename, "w");
    for($i=0; $i<count($lines_base); $i++) {
        if(strripos($lines_base[$i], $login) !== false){
            continue;
        }
        fwrite($base,$lines_base[$i]);
    }
    fwrite($base,"\r\n");
    if (fputcsv($base,$append_data)===false){
        fclose($base);
        return 0;
    }
    fclose($base);
    return 1;
}
function write_login_and_pass($filename,$login,$password){
     $base = fopen($filename, 'a');
     $append_data=array ($login,$password);
     if (fputcsv($base,$append_data)===false){
        fclose($base);
        return 0;
     }
    fclose($base);
    return 1;
}
function delete_token($filename,$token){
    $lines_base=file($filename);//split the base into lines
    $base=fopen($filename, "w");
    $append_data_count=0;
    for($i=0; $i<count($lines_base); $i++) {
        if(strripos($lines_base[$i], $token) !== false){
            $append_data_count=$i;
            continue;
        }
        fwrite($base,$lines_base[$i]);
    }
    fwrite($base,"\r\n");
    $pieces = explode(",", $lines_base[$append_data_count]);
    $append_data=array($pieces[0],$pieces[1]);
    if (fputcsv($base,$append_data)===false){
        fclose($base);
        return 0;
    }
    fclose($base);
    return 1;
}
function create_token() {
    return md5(uniqid(mt_rand(), true));//create 32-symbols id (128-bits hex number),hash
}
function create_password_hash($password){
    return hash("sha256",$password);
}
?>
