<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "OPD";

$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn){
    die("Error". mysqli_connect_error());
}

$sql = "CREATE TABLE IF NOT EXISTS `notifications` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `userId` int(11) NOT NULL,
    `orderId` int(11) NOT NULL,
    `message` text NOT NULL,
    `status` tinyint(1) DEFAULT 0,
    `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
)";
mysqli_query($conn, $sql);

?>
