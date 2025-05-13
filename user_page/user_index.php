<?php
session_start();

require_once "../login/config.inc.php"; // 包含数据库连接文件
require_once '../vendor/autoload.php'; // 包含Parsedown库

// 获取当前登录用户的邮箱
$adminMail = isset($_SESSION['adminMail']) ? $_SESSION['adminMail'] : '';

// 查询当前登录用户的博客
$query = "SELECT blogNo, blogTopic, blogContent FROM blog WHERE adminMail = ? ORDER BY importDate DESC";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('s', $adminMail);
$stmt->execute();
$result = $stmt->get_result();

$Parsedown = new Parsedown();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Success</title>
    <link rel="stylesheet" href="../css/user.css">
    <script src="../js/jquery-2.1.4.js"></script>
    <script src="../js/main.js"></script>
</head>

<body>
    <div class="user_background">
        <div class="user_container">
            <div class="user_header">
                <h1>Welcome, <?php echo isset($_SESSION['adminName']) ? htmlspecialchars($_SESSION['adminName']) : 'Guest'; ?>!</h1>
                <p>You have successfully logged in as <?php echo isset($_SESSION['level']) ? htmlspecialchars($_SESSION['level']) : 'unknown level'; ?>.</p>
                <p><a href="log_out.php" class="button">Logout</a></p>
                <p><a href="blogOut.html" class="button">Publish Blog</a></p>
            </div>
            <div class="user_blog">
                <div class="blog-container">
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <div class="blog-preview">
                            <h1><?php echo htmlspecialchars($row['blogTopic']); ?></h1>
                            <div class="blog-content">
                                <?php
                                $content = $row['blogContent'];
                                $content = mb_substr($content, 0, 100, 'UTF-8');
                                echo $Parsedown->text($content);
                                ?>
                            </div>
                            <p><a href="blogView.php?blogNo=<?php echo $row['blogNo']; ?>" class="button">Read More</a></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
$stmt->close();
$mysqli->close();
?>