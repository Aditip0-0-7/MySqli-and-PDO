<?php
include 'db_conect_pdo.php';

/* ===== บันทึก (เพิ่ม/แก้ไข) ===== */
if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];

    if ($id == "") {
        $sql = "INSERT INTO users (name, sex, phone, email, birthday)
                VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $sex, $phone, $email, $birthday]);
    } else {
        $sql = "UPDATE users SET
                name=?, sex=?, phone=?, email=?, birthday=?
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $sex, $phone, $email, $birthday, $id]);
    }
    header("Location: show_users_pdo.php");
    exit;
}

/* ===== ลบ ===== */
if (isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->execute([$_POST['delete_id']]);
    header("Location: show_users_pdo.php");
    exit;
}

/* ===== ดึงข้อมูล ===== */
$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ข้อมูลผู้ใช้</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">
<div class="container mt-4">

<h2 class="fw-bold">ข้อมูลผู้ใช้</h2>

<button class="btn btn-success mb-3"
        data-bs-toggle="modal"
        data-bs-target="#userModal"
        onclick="clearForm()">
<i class="bi bi-plus-circle"></i> เพิ่มผู้ใช้
</button>

<table class="table table-bordered table-striped">
<thead class="table-dark text-center">
<tr>
<th>ID</th><th>ชื่อ</th><th>เพศ</th><th>โทรศัพท์</th>
<th>Email</th><th>วันเกิด</th><th>จัดการ</th>
</tr>
</thead>

<tbody>
<?php foreach ($users as $u): ?>
<tr>
<td class="text-center"><?= $u['id'] ?></td>
<td><?= $u['name'] ?></td>
<td><?= $u['sex'] ?></td>
<td><?= $u['phone'] ?></td>
<td><?= $u['email'] ?></td>
<td><?= $u['birthday'] ?></td>
<td class="text-center">

<button class="btn btn-warning btn-sm"
data-bs-toggle="modal"
data-bs-target="#userModal"
onclick='editUser(<?= json_encode($u) ?>)'>
<i class="bi bi-pencil"></i> แก้ไข
</button>

<button class="btn btn-danger btn-sm"
data-bs-toggle="modal"
data-bs-target="#deleteModal"
onclick="setDelete(<?= $u['id'] ?>)">
<i class="bi bi-trash"></i> ลบ
</button>

</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<!-- ===== Modal เพิ่ม/แก้ไข ===== -->
<div class="modal fade" id="userModal">
<div class="modal-dialog">
<div class="modal-content">
<form method="post">

<div class="modal-header">
<h5 class="modal-title">ข้อมูลผู้ใช้</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<input type="hidden" name="id" id="id">

<div class="mb-2">
<label>ชื่อ</label>
<input type="text" name="name" id="name" class="form-control" required>
</div>

<div class="mb-2">
<label>เพศ</label>
<select name="sex" id="sex" class="form-select" required>
<option value="">-- เลือก --</option>
<option value="ชาย">ชาย</option>
<option value="หญิง">หญิง</option>
</select>
</div>

<div class="mb-2">
<label>โทรศัพท์</label>
<input type="text" name="phone" id="phone" class="form-control" required>
</div>

<div class="mb-2">
<label>Email</label>
<input type="email" name="email" id="email" class="form-control" required>
</div>

<div class="mb-2">
<label>วันเกิด</label>
<input type="date" name="birthday" id="birthday" class="form-control" required>
</div>
</div>

<div class="modal-footer">
<button type="submit" name="save" class="btn btn-success">
<i class="bi bi-save"></i> บันทึก
</button>
</div>

</form>
</div>
</div>
</div>

<!-- ===== Modal ลบ ===== -->
<div class="modal fade" id="deleteModal">
<div class="modal-dialog modal-sm">
<div class="modal-content">
<form method="post">

<div class="modal-header bg-danger text-white">
<h5 class="modal-title">ยืนยันการลบ</h5>
</div>

<div class="modal-body text-center">
ต้องการลบข้อมูลนี้หรือไม่?
<input type="hidden" name="delete_id" id="delete_id">
</div>

<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
<button type="submit" name="delete" class="btn btn-danger">ลบ</button>
</div>

</form>
</div>
</div>
</div>

<script>
function clearForm(){
    document.getElementById('id').value='';
    document.getElementById('name').value='';
    document.getElementById('sex').value='';
    document.getElementById('phone').value='';
    document.getElementById('email').value='';
    document.getElementById('birthday').value='';
}

function editUser(u){
    id.value = u.id;
    name.value = u.name;
    sex.value = u.sex;
    phone.value = u.phone;
    email.value = u.email;
    birthday.value = u.birthday;
}

function setDelete(id){
    document.getElementById('delete_id').value = id;
}
</script>

</body>
</html>
