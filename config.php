<?php 
// memanggil koneksi database
$server = "us-cdbr-east-02.cleardb.com";
$user = "b848dcd379f31a";
$pass = "efed4f22";
$database = "heroku_73d1e5bc68e7e25";

$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));
