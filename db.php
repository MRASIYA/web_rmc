<?php
$servername = "sql109.infinityfree.com";
$username = "if0_38749597";
$password = "Aruni8281";
$dbname = "if0_38749597_data_entry_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
