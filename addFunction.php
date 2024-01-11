<?php
$conn = mysqli_connect ("localhost", "root", "", "cardb");
if (isset($_POST['Function'])) {
    $func = $_POST['func'];
    $level = $_POST['level'];
    $status = $_POST['status'];
    mysqli_query($conn, "INSERT INTO `api_function` (`id`, `FuncName`, `NeedLevel`, `Status`) VALUES (NULL, '$func', '$level', '$status')");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Добавление функционала</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="func" id="">
        <input type="text" name="level" id="">
        <input type="text" name="status" id="">
        <input type="submit" name="Function" id="">
    </form>
</body>
</html>