<?php 
    $userNav = getUserMenu();
?>
<footer class="mt-auto bg-body-tertiary">
   <div class="container py-3 px-1">
       <?php if(!isset($_SESSION['user']) || isset($_SESSION['user']) && $_SESSION['user']->role_id == 2):?>
            <div class="row px-2 py-1 text-center align-items-center ">
                <div class="col-lg-4 text-center mb-2 mb-lg-0 align-items-center">
                   <h2> <a href="index.php" class="nav-link text-uppercase fw-bold">Avanturista</a></h2>
                   <p class="fs-5">
                   „Najbolji način da doživite prirodu je peške. – Muir
                   </p>
                </div>
                <div class="col-lg-4">
                    <p class="mb-2 fs-3 fw-bold">Brzi linkovi</p>
                    <div class="navbar-nav d-flex flex-column gap-1">
                        <?php foreach($userNav as $nav):?>
                        <li class="nav-item"><a href="index.php?page=<?=$nav->name?>" class="nav-link"><?=ucfirst($nav->name)?></a></li>
                        <?php endforeach;?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex align-items-center gap-2 fw-bold ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:36px; height:36px;" class="bg-dark rounded-circle px-2 py-2 text-light">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                <span><a href="models/docs.pdf" class="nav-link">Dokumnetacija</a></span>
                        </div>
                        <div class="d-flex align-items-center gap-2 fw-bold ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  style="width:36px; height:36px;" class="bg-dark rounded-circle px-2 py-2 text-light">
  <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
</svg> <span>avanturista@gmail.com</span>
                        </div>
                    </div>
                </div>
            </div>
       <?php endif;?>
   </div>
</footer>
<script src="assets/js/jquery.min.js"></script>
<?php if(!isset($_SESSION['user'])):?>
<script src="assets/js/auth.js"></script>
<?php endif;?>
<script src="assets/js/utilities.js"></script>
<script src="assets/js/validation.js"></script>
<?php if(isset($_SESSION['user']) && $_SESSION['user']->role_id == 1):?>
<script src="assets/js/admin.js"></script>
<?php endif;?>
<script src="assets/js/bootstrap.bundle.min.js"></script> 
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<?php if(!isset($_SESSION['user']) ||isset($_SESSION['user']) && $_SESSION['user']->role_id == 2):?>
<script src="assets/js/user.js"></script>
<?php endif;?>
</body>
</html>
