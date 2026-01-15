<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document แสดงข้อมูลผู ตาราง</title>
</head>
<body>
<h1>แสดงข้อมูลผู้ใช้จากฐานข้อมูล</h1>
<?php
include 'db_connect.php';
$sql = "SELECT * FROM users";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='10'>\n";
    echo "<tr><th>รหัส</th><th>ชื่อ</th><th>เพศ</th>";
    echo  "<th>เบอร์โทร</th><th>อีเมล</th><th>วันเกิด</th></tr>\n";

    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
             echo   "<td>" . $row["id"] . "</td>";
             echo   "<td>" . $row["name"] . "</td>";
             echo   "<td>" . $row["sex"] . "</td>";
             echo   "<td>" . $row["phone"] . "</td>";
             echo   "<td>" . $row["email"] . "</td>";
             echo "<td>" . $row["birthday"] . "</td>";
             echo "</tr>\n";
    }
    echo "</table>";
} else {

    echo "0 results";
}
    mysqli_close($conn);
?>

</body>
</html>
