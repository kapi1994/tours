<?php 
$homeUrl = "";
$navigation = "";
  if(!isset($_SESSION['user']) || isset($_SESSION['user']) && $_SESSION['user']->role_id == 2){
    $homeUrl = "index.php";
  }else if(isset($_SESSION['user']) && $_SESSION['user']->role_id == 1){
    $homeUrl = "admin.php";
  }
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="<?=$homeUrl?>">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <?php if(!isset($_SESSION['user']) || isset($_SESSION['user']) && $_SESSION['user']->role_id == 2):?>
        <li class="nav-item"><a href="index.php?page=home" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'home' ? 'active border-bottom' : ''?>">Home</a></li>
        <li class="nav-item"><a href="index.php?page=tours" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'tours' ? 'active border-bottom' : ''?>">Torus</a></li>
        <li class="nav-item"><a href="index.php?page=contact" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'contact' ? 'active border-bottom' : ''?>">Contact</a></li>
        <?php elseif(isset($_SESSION['user']) && $_SESSION['user']->role_id == 1):?>
          <li class="nav-item"><a href="admin.php?page=home" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'home' ? 'active border-bottom' : ''?>">Home</a></li
          <li class="nav-item"><a href="admin.php?page=survey" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'survey' ? 'active border-bottom' : ''?>">Survey</a></li>
          <li class="nav-item"><a href="admin.php?page=categories" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'categories' ? 'active border-bottom' :''?>">Categories</a></li>
          <li class="nav-item"><a href="admin.php?page=posts" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'posts' ? 'active border-bottom' :''?>">Posts</a></li>
          <li class="nav-item"><a href="admin.php?page=messages" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'messages' ? 'active border-bottom' : ''?>">Messages</a></li>
        <?php endif;?>
      </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <?php if(!isset($_SESSION['user'])):?>
          <li class="nav-item"><a href="index.php?page=login" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'login'? 'active border-bottom':''?>">Log in</a></li>
          <li class="nav-item"><a href="index.php?page=register" class="nav-link  <?= isset($_GET['page']) && $_GET['page'] == 'register'? 'active border-bottom':''?>">Register</a></li>
          <?php else:?>
            <li class="nav-item"><a href="models/auth/logout.php" class="nav-link">Logout</a></li>
          <?php endif;?>
        </ul>
    </div>
  </div>
</nav>