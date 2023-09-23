<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>STD Info System Student</title>
</head>


<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="insert_std_form.php">ระบบจัดการข้อมูลนักเรียน</a>
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

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            echo "<div class='alert alert-danger'>เชื่อมต่อฐานข้อมูลไม่สำเร็จ โปรดลองเชื่อมต่อใหม่อีกครั้ง</div>";
            die();
        }

        if (isset($_POST['std_student_submit'])) {
            $id = (int)trim($_POST['id']);
            $en_name = trim($_POST['en_name']);
            $en_surname = trim($_POST['en_surname']);
            $th_name = trim($_POST['th_name']);
            $th_surname = trim($_POST['th_surname']);
            $major_code = trim($_POST['major_code']);
            $email = trim($_POST['email']);
            $validate_ = true;

            if (empty($id) || empty($en_name) || empty($en_surname) || empty($th_name) || empty($th_surname)) {
                $_SESSION['error'] = 'Some data is required , please enter your data all at once and try again.';
                $validate_ = false;
            } else if (!filter_var($email ,FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Email is invalid , please enter email correctly formatted.";
                $validate_ = false;
            } else if (strlen($major_code) > 3) {
                $_SESSION['error'] = "Major code can only length 3, please enter a valid major code.";
                $validate_ = false;
            }

            if (!$validate_) {
                echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>";
                echo "<a class='btn btn-primary' href='insert_std_form.php'>Back To Page</a>";
                die();
            }

            $sql = "INSERT INTO `std_info` (`id`, `en_name`, `en_surname`, `th_name`, `th_surname`, `major_code`, `email`) VALUES ($id, '$en_name', '$en_surname', '$th_name', '$th_surname', '$major_code', '$email')";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<div class='alert alert-success'>New recorded successfully.</div>";
            } else {
                echo "<div class='alert alert-danger'>" . "Error: " . mysqli_error($conn) . "</div>";
                echo "<a class='btn btn-primary' href='insert_std_form.php'>Back To Page</a>";
                die();
            }
        }

        ?>

        <?php
        $selectData = "select * from std_info";
        $result = mysqli_query($conn, $selectData);
        ?>

        <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method="post" class="row my-3" id="form">
            <h1 class="display-6 md-3">แบบฟอร์มเพิ่มข้อมูล</h1>
            <div class="col-sm-5">
                หมายเลขไอดี: <input class="form-control" type="text" name="id" id=""><br>
                ชื่อภาษาอังกฤษ: <input class="form-control" type="text" name="en_name" id=""><br>
                นามสกุลภาษาอังกฤษ: <input class="form-control" type="text" name="en_surname" id=""><br>
            </div>
            <div class="col-sm-5">
                ชื่อภาษาไทย: <input class="form-control" type="text" name="th_name" id=""><br>
                นามสกุลภาษาไทย: <input class="form-control" type="text" name="th_surname" id=""><br>
                รหัสสาขา: <input class="form-control" type="text" name="major_code" id=""><br>
            </div>
            <div class="col-sm-5">
                อีเมล: <input class="form-control" type="text" name="email" id=""><br>
                <input class="btn btn-success" type="submit" value="บันทึก" name="std_student_submit">
                <input class="btn btn-danger" type="reset" value="ยกเลิก">
            </div>
            <hr style="margin-top: 1rem;">
        </form>
        <div class="my-3">
            <h2 class="display-6">รายการข้อมูลนักเรียน</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">หมายเลขไอดี</th>
                        <th scope="col">ชื่อภาษาอังกฤษ</th>
                        <th scope="col">นามสกุลภาษาอังกฤษ</th>
                        <th scope="col">ชื่อไทย</th>
                        <th scope="col">นามสกุลภาษาไทย</th>
                        <th scope="col">รหัสสาขา</th>
                        <th scope="col">อีเมล</th>
                        <th scope="col">แก้ไข</th>
                        <th scope="col">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <th scope="row"><?php echo $row['id'] ?></th>
                            <td><?php echo $row['en_name'] ?></td>
                            <td><?php echo $row['en_surname'] ?></td>
                            <td><?php echo $row['th_name'] ?></td>
                            <td><?php echo $row['th_surname'] ?></td>
                            <td><?php echo $row['major_code'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><button type="button" class="btn btn-primary edit_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">edit</button></td>
                            <td><a class="btn btn-danger delete_btn" href="delete_std.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Are you sure to delete this record?!')">delete</a></td>
                        </tr>
                        <tr>
                            <td>
                                <form action='<?php echo htmlspecialchars('/php_week9/update_std.php') ?>' method="post" class="row form_update" style="display: none; width: 100%;">
                                    <h2 class="display-6">แก้ไขข้อมูล</h2>
                                    <div class="col-sm-20">
                                        หมายเลขไอดี: <input class="form-control" type="text" value="<?php echo $row['id'] ?>" name="id" id=""><br>
                                        ชื่อภาษาอังกฤษ: <input class="form-control" type="text" value="<?php echo $row['en_name'] ?>" name="en_name" id=""><br>
                                        นามสกุลภาษาอังกฤษ: <input class="form-control" type="text" value="<?php echo $row['en_surname'] ?>" name="en_surname" id=""><br>
                                    </div>
                                    <div class="col-sm-20">
                                        ชื่อไทย: <input class="form-control" type="text" value="<?php echo $row['th_name'] ?>" name="th_name" id=""><br>
                                        นามสกุลไทย: <input class="form-control" type="text" value="<?php echo $row['th_surname'] ?>" name="th_surname" id=""><br>
                                        รหัสสาขา: <input class="form-control" type="text" value="<?php echo $row['major_code'] ?>" name="major_code" id=""><br>
                                    </div>
                                    <div class="col-sm-20">
                                        อีเมล: <input class="form-control" type="text" value="<?php echo $row['email'] ?>" name="email" id=""><br>
                                        <input class="btn btn-success" type="submit" value="ยืนยัน">
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        const toggle_form = document.getElementById('toggle_form');
        const form = document.getElementById('form');
        const edit_btn = document.getElementsByClassName('edit_btn');
        const form_btn = document.getElementsByClassName('form_update');
        let toggle_state_form = false;
        let toggle_state_form_update = false;

        form.style.display = 'none';
        toggle_form.addEventListener('click', (event) => {
            toggle_state_form = !toggle_state_form;
            if (toggle_state_form) {
                form.style.display = 'flex';
            } else {
                form.style.display = 'none';
            }
        })

        for (let index = 0; index < edit_btn.length; index++) {
            const button = edit_btn[index];
            const form_update = form_btn[index];
            button.addEventListener('click', (event) => {
                toggle_state_form_update = !toggle_state_form_update;
                if (toggle_state_form_update) {
                    form_update.style.display = 'flex';
                } else {
                    form_update.style.display = 'none';
                }
            })
        }
    </script>
</body>

</html>