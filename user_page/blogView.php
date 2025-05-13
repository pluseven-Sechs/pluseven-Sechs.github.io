<?php
session_start();
require_once "../login/config.inc.php"; // 包含数据库连接文件

$blogNo = isset($_GET['blogNo']) ? intval($_GET['blogNo']) : 0;

$query = "SELECT blogTopic, blogContent, adminMail, importDate FROM blog WHERE blogNo = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $blogNo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $blog = $result->fetch_assoc();
} else {
    echo "Blog not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['blogTopic']); ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($blog['blogTopic']); ?></h1>
        <p><em><?php echo htmlspecialchars($blog['importDate']); ?></em></p>
        <p><?php echo nl2br(htmlspecialchars($blog['blogContent'])); ?></p>
        <p><a href="user_index.php" class="button">Back to Blog List</a></p>
    </div>
</body>

</html>

<?php
$stmt->close();
$mysqli->close();
?>