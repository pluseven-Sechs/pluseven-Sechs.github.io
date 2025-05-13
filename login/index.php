<?php
session_start();

// 检查用户是否已登录
$isLoggedIn = isset($_SESSION['adminName']);
?>

<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/reset.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/base.css" />
  <script src="../js/modernizr.js"></script>
  <script src="../js/jquery-2.1.4.js"></script>
  <script src="../js/main.js"></script>
  <title>inkLounge</title>
</head>

<body>
  <div class="intro">
    <a href="#0" class="cd-modal-trigger">
      <button class="button-intro">
        <span class="button-text">斋</span>
        <img src="../img/bt.png"></img>
      </button>
    </a>
  </div>
  <div class="cd-modal">
    <div class="header">
      <div class="logo">
        <a href="index.php">
          <span class="header-text">inkLounge</span>
        </a>
      </div>
      <div class="user-center">
        <a href="<?php echo $isLoggedIn ? '../user_page/user_index.php' : 'login.html'; ?>">
          <?php echo $isLoggedIn ? 'My Blog' : 'Personal Center'; ?>
        </a>
      </div>
    </div>
    <div class="modal-content">
      <h1>Welcome to inkLounge</h1>
      <p>Your place to share and explore blogs.</p>
    </div>
  </div>

  <div class="cd-transition-layer">
    <div class="bg-layer"></div>
  </div>


</body>

</html>