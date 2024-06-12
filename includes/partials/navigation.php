<?php 
$homeUrl = "";
$navigation = "";
$route = '';
  if(!isset($_SESSION['user']) || isset($_SESSION['user']) && $_SESSION['user']->role_id == 2){
    $homeUrl = "index.php";
    $navigation = getUserMenu();
  }else if(isset($_SESSION['user']) && $_SESSION['user']->role_id == 1){
    $homeUrl = "admin.php";
    $navigation = getAdminMenu();
  }
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand fw-bold text-uppercase" href="<?=$homeUrl?>">Avanturista</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <?php foreach($navigation as $home):?>
        <li class="nav-item"><a href="<?=$homeUrl?>?page=<?=$home->name?>" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == $home->name ? 'active border-bottom' : ''?>"><?=ucfirst($home->name)?></a></li>
      <?php endforeach;?>
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