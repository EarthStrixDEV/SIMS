<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<div class="container">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="insert_std_form.php">ระบบจัดการข้อมูลนักเรียน By PHP</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#" id="toggle_form">เพิ่มข้อมูล</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "students";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    echo "<div class='alert alert-danger'>เชื่อมต่อฐานข้อมูลไม่สำเร็จ โปรดลองเชื่อมต่อใหม่อีกครั้ง</div>";
    die();
}

$id = (int)$_GET['id'];
$sql = "DELETE FROM std_info WHERE id = $id";

$result = mysqli_query($conn, $sql);

if ($result) {
    setcookie('delete_success','ลบข้อมูลที่ ID = '.$id.' เรียบร้อย' ,time() + 5);
    header('Location:insert_std_form.php');
} else {
    setcookie('delete_error','เกิดข้อผิดพลาดในการดำเนินการ โปรดลองอีกครั้ง' ,time() + 5);
    header('Location:insert_std_form.php');
}

?>
</div>