<!DOCTYPE html>
<html lang="en">
<?php
session_start();
session_unset();
session_destroy();
header("location: login.html")
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>