<?php
include 'db_connect.php';

// เพิ่ม / แก้ไข
if (isset($_POST['save'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];

    // ถ้ามี id = แก้ไข
    if (!empty($id)) {
        $sql = "UPDATE users SET
                    name='$name',
                    sex='$sex',
                    phone='$phone',
                    email='$email',
                    birthday='$birthday'
                WHERE id=$id";
    }
    // ถ้าไม่มี id = เพิ่มใหม่
    else {
        $sql = "INSERT INTO users (name, sex, phone, email, birthday)
                VALUES ('$name','$sex','$phone','$email','$birthday')";
    }

    $conn->query($sql);
    header("Location: crud_users.php");
}

// ลบ
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: crud_users.php");
}

// ดึงข้อมูลมาแก้
$edit = false;
if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM users WHERE id=$id");
    $row = $result->fetch_assoc();
}
?>



<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>CRUD Users</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2 class="mb-3">ฟอร์มข้อมูลผู้ใช้</h2>

<form method="post">
    <input type="hidden" name="id" value="<?= $edit ? $row['id'] : '' ?>">

    <div class="mb-2">
        <label>ชื่อ</label>
        <input type="text" name="name" class="form-control"
               value="<?= $edit ? $row['name'] : '' ?>" required>
    </div>

    <div class="mb-2">
        <label>เพศ</label>
        <select name="sex" class="form-control" required>
            <option value="">-- เลือก --</option>
            <option value="ชาย" <?= ($edit && $row['sex']=="ชาย")?'selected':'' ?>>ชาย</option>
            <option value="หญิง" <?= ($edit && $row['sex']=="หญิง")?'selected':'' ?>>หญิง</option>
        </select>
    </div>

    <div class="mb-2">
        <label>เบอร์โทร</label>
        <input type="text" name="phone" class="form-control"
               value="<?= $edit ? $row['phone'] : '' ?>" required>
    </div>

    <div class="mb-2">
        <label>Email</label>
        <input type="email" name="email" class="form-control"
               value="<?= $edit ? $row['email'] : '' ?>" required>
    </div>

    <div class="mb-2">
        <label>วันเกิด</label>
        <input type="date" name="birthday" class="form-control"
               value="<?= $edit ? $row['birthday'] : '' ?>" required>
    </div>

    <button type="submit" name="save" class="btn btn-success mt-2">
        <?= $edit ? 'อัปเดต' : 'บันทึก' ?>
    </button>
</form>

<hr>

<h2>รายการผู้ใช้</h2>

<table class="table table-bordered">
<tr class="table-dark">
    <th>ID</th>
    <th>ชื่อ</th>
    <th>เพศ</th>
    <th>เบอร์</th>
    <th>Email</th>
    <th>วันเกิด</th>
    <th>จัดการ</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM users");
while ($row = $result->fetch_assoc()):
?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['sex'] ?></td>
    <td><?= $row['phone'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['birthday'] ?></td>
    <td>
        <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">แก้ไข</a>
        <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('ยืนยันการลบ?')">ลบ</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
