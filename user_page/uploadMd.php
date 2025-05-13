<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION["adminName"]) || empty($_SESSION["adminName"])) {
    echo '<script>alert("请先登录！");location="login.php";</script>';
    exit();
}

$blogTopic = isset($_POST['blogTopic']) ? $_POST['blogTopic'] : '';
$adminMail = isset($_SESSION["adminMail"]) ? $_SESSION["adminMail"] : '';
$blogContent = isset($_POST["blogcontent"]) ? $_POST["blogcontent"] : '';

// 检查博客主题和博客内容或文件是否为空
if (empty($blogTopic) || (empty($blogContent) && empty($_FILES['blogfile']['name']))) {
    echo '<script>alert("请填写完整的博客主题和内容或上传文件！");location="blogOut.html";</script>';
    exit();
}

// 如果上传了文件，则读取文件内容
if (isset($_FILES['blogfile']) && $_FILES['blogfile']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['blogfile']['tmp_name'];
    $fileName = $_FILES['blogfile']['name'];
    $fileSize = $_FILES['blogfile']['size'];
    $fileType = $_FILES['blogfile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedfileExtensions = array('md');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        $blogContent = file_get_contents($fileTmpPath);
    } else {
        echo '<script>alert("只允许上传Markdown文件！");location="blogOut.html";</script>';
        exit();
    }
}

date_default_timezone_set('Asia/Shanghai'); // 设置为北京时间
$blogDate = date("Y-m-d"); // 自动获取时间(年月日)

require_once "../login/config.inc.php";

// 插入BLOG信息命令
$stmt = $mysqli->prepare("INSERT INTO `blog` (`blogTopic`, `blogContent`, `adminMail`, `importDate`) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $blogTopic, $blogContent, $adminMail, $blogDate);

if ($stmt->execute()) {
    $stmt->close();
    $mysqli->close(); // 查询已经结束，在这里关闭连接
    echo '<script>alert("博客发表成功");location="user_index.php";</script>';
} else {
    $stmt->close();
    $mysqli->close();
    echo '<script>alert("博客发表失败");location="user_index.php";</script>';
}
