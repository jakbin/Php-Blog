<?php

$dsn = "mysql:host=localhost;dbname=phpblog";

$conn = new PDO($dsn, "root","");
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
?>
