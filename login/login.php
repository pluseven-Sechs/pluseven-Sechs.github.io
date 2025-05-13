<?php
    session_start();
?>
<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1.0">
<?php
    $admin = $_REQUEST['admin'];
    $password = $_REQUEST['password'];

    if($admin == "" || $password == ""){
        echo "<script>alert('用户名密码不能为空。');location='login.php';</script>";
        exit;
    }

    require_once("config.inc.php");

    $demand = "SELECT level,password,adminName FROM admin WHERE adminMail = '$admin'";
    $res = mysqli_query($mysqli,$demand);
    $power = mysqli_fetch_row($res);
    $_SESSION['adminMail'] = $admin;
    $_SESSION['password'] = $password;
    $_SESSION['level'] = $power[0];

    if($power[1] == $password){
        $_SESSION["adminName"]=$power[2];
        if($power[0] == 'user'){
            header('location:../user_page/user_index.php');
        }else if($power[0] == 'super'){
            header('location:admin_index.php');
        }else{
            echo '<script>alert("未知错误，请联系管理员");location="login.php";</script>';
            exit;
        }
    }
    else{
        echo '<script>alert("用户名或密码错误，请重新登陆");location=:"login.php";</script>';
    }
    
    mysqli_free_result($res);
    mysqli_close($mysqli);
