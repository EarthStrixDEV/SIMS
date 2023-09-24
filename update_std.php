<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
                            <a class="btn btn-primary" href="#" id="toggle_form">เพิ่มข้อมูล</a>
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

        $conn = mysqli_connect($servername ,$username ,$password ,$dbname);

        if (!$conn) {
            echo "<div class='alert alert-danger'>เชื่อมต่อฐานข้อมูลไม่สำเร็จ โปรดลองเชื่อมต่อใหม่อีกครั้ง</div>";
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (int)trim($_POST['id']);
            $en_name = trim($_POST['en_name']);
            $en_surname = trim($_POST['en_surname']);
            $th_name = trim($_POST['th_name']);
            $th_surname = trim($_POST['th_surname']);
            $major_code = trim($_POST['major_code']);
            $email = trim($_POST['email']);

            $validate_ = true;

            if (empty($en_name) || empty($en_surname) || empty($th_name) || empty($th_surname)) {
                setcookie('update_error' ,'ข้อมูลบางฟิลด์ไม่ควรเป็นค่าว่าง โปรดกรอกข้อมูลให้ครบถ้วนแล้วลองอีกครั้ง',time() + 5);
                $validate_ = false;
            } else if (!filter_var($email ,FILTER_VALIDATE_EMAIL)) {
                setcookie('update_error' ,'รูปแบบอีเมลไม่ถูกต้อง โปรดกรอกอีเมลให้ถูกต้องตามรูปแบบ',time() + 5);
                $validate_ = false;
            } else if (strlen($major_code) > 3) {
                setcookie('update_error' ,'รหัสสาขาควรมีแค่ 3 อักขระเท่านั้น โปรดกรอกรหัสสาขาที่ถูกต้องตามรูปแบบ',time() + 5);
                $validate_ = false;
            }

            if (!$validate_) {
                header('Location:insert_std_form.php');
            } else {
                $sql = "UPDATE std_info SET en_name = '$en_name', en_surname = '$en_surname', th_name = '$th_name', th_surname = '$th_surname', major_code = '$major_code', email = '$email' WHERE id = $id";

                if (mysqli_query($conn ,$sql)) {
                    setcookie('update_success' ,'ข้อมูลที่ ID = '.$id .' ถูกแก้ไขเรียบร้อยแล้ว.',time() + 5);
                    header('Location:insert_std_form.php');
                } else {
                    echo "<div class='alert alert-danger my-3'>".mysqli_error($conn)."</div>";
                    echo "<a href='insert_std_from.php' class='btn btn-primary'>กลับไปที่หน้าเพจ</a>";
                }
            }

            $conn->close();
        }

        ?>
    </div>
</body>
</html>