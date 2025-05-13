<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $adminMail = isset($_POST['adminMail']) ? trim($_POST['adminMail']) : '';
        $adminName = isset($_POST['adminName']) ? trim($_POST['adminName']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $level = 'user';

        if ($adminMail == "" || $adminName == "" || $password == "") {
            echo '<script type="text/javascript">alert("用户名、密码或邮箱不能为空");location="register.php";</script>';
            exit;
        }

        require_once "config.inc.php";

        if ($mysqli->connect_errno) {
            die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        }

        // 检查邮箱是否已注册
        $stmt = $mysqli->prepare("SELECT * FROM admin WHERE adminMail = ?");
        if ($stmt) {
            $stmt->bind_param('s', $adminMail);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                echo '<script type="text/javascript">alert("该邮箱已注册！");location="signup.php";</script>';
                $stmt->close();
                $mysqli->close();
                exit;
            }
            $stmt->close();
        } else {
            echo '<script type="text/javascript">alert("数据库查询失败");location="register.php";</script>';
            $mysqli->close();
            exit;
        }

        // 使用预处理语句插入数据
        $stmt = $mysqli->prepare("INSERT INTO admin (adminMail, adminName, password, level) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param('ssss', $adminMail, $adminName, $password, $level);
            $res1 = $stmt->execute();
            if ($res1) {
                $_SESSION['adminName'] = $adminName;
                echo '<script type="text/javascript">alert("注册成功！");location="login.html";</script>';
            } else {
                echo '<script type="text/javascript">alert("注册失败，请重试");location="register.php";</script>';
            }
            $stmt->close();
        } else {
            echo '<script type="text/javascript">alert("数据库查询失败");location="register.php";</script>';
        }

        $mysqli->close();
    }
    ?>
</body>

</html>