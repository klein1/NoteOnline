<?php
$servername = "115.159.181.16";
$username = "root";
$password = "udcong";
$dbname = "udcong";

$content = $_POST["input"];
 
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
 
$sql = "INSERT INTO db_note(content, create_time, state) VALUES ('". htmlspecialchars($content) . "', now(), '1')";
 
if ($conn->query($sql) === TRUE) {
      echo "ok";
} else {
    echo "Error";
}

$conn->close();
?>