<?php

$host    = "localhost";
$user    = "root";
$pass    = "";
$db      = "crud_native_0";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if(!$koneksi){
    die("Gagal terhubung: ". mysqli_connect_error());
}

?>