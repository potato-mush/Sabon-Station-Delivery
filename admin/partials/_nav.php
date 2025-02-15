<?php
if (!isset($_SESSION)) {
    session_start();
}

// Initialize default values
$userInfo = array(
    'username' => 'Guest',
    'image' => 'profile/profilePic.jpg' // Updated default path
);

// Only try to fetch user info if logged in
if (isset($_SESSION['adminloggedin']) && $_SESSION['adminloggedin'] == true && isset($_SESSION['adminuserId'])) {
    include '_dbconnect.php';
    $userId = $_SESSION['adminuserId'];
    $sql = "SELECT username, image FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            $userInfo = $row;
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<header class="header" id="header">
    <div class="header__toggle">
        <i class='bx bx-menu' id="header-toggle"></i>
    </div>

    <div class="header__user d-flex align-items-center">
        <span class="mr-2 text-dark"><?php echo htmlspecialchars($userInfo['username']); ?></span>
        <div class="header__img">
            <img src="../img/<?php echo htmlspecialchars($userInfo['image']); ?>" alt="User Image"
                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"
                onerror="this.src='../img/profile/profilePic.jpg'">
        </div>
    </div>
</header>

<div class="l-navbar" id="nav-bar">
  <nav class="nav">
    <div>
      <a href="index.php" class="nav__logo">
        <i class='bx bx-layer nav__logo-icon'></i>
        <span class="nav__logo-name">Sabon Station</span>
      </a>

      <div class="nav__list">
        <a href="index.php" class="nav__link nav-home">
          <i class='bx bx-grid-alt nav__icon'></i>
          <span class="nav__name">Home</span>
        </a>
        <a href="index.php?page=orderManage" class="nav-orderManage nav__link ">
          <i class='bx bx-bar-chart-alt-2 nav__icon'></i>
          <span class="nav__name">Orders</span>
        </a>
        <a href="index.php?page=categoryManage" class="nav__link nav-categoryManage">
          <i class='bx bx-folder nav__icon'></i>
          <span class="nav__name">Category List</span>
        </a>
        <a href="index.php?page=menuManage" class="nav__link nav-menuManage">
          <i class='bx bx-message-square-detail nav__icon'></i>
          <span class="nav__name">Product List</span>
        </a>
        <a href="index.php?page=contactManage" class="nav__link nav-contactManage">
          <i class="fas fa-hands-helping"></i>
          <span class="nav__name">contact Info</span>
        </a>
        <a href="index.php?page=userManage" class="nav__link nav-userManage">
          <i class='bx bx-user nav__icon'></i>
          <span class="nav__name">Users</span>
        </a>
        <a href="index.php?page=siteManage" class="nav__link nav-siteManage">
          <i class="fas fa-cogs"></i>
          <span class="nav__name">Site Settings</span>
        </a>
      </div>
    </div>
    <a href="partials/_logout.php" class="nav__link">
      <i class='bx bx-log-out nav__icon'></i>
      <span class="nav__name">Log Out</span>
    </a>
  </nav>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
  <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home'; ?>
  $('.nav-<?php echo $page; ?>').addClass('active')
</script>