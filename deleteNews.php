<?php
session_start();
require_once 'db_connection.php';
if(isset($_GET['id'])) {
    mysqli_query($conn, "UPDATE news SET IsDeleted = 1 WHERE Id = '{$_GET['id']}'");
}
header("Location: viewNews.php");
?>