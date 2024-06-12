<?php 
$getTours = getMainTours();?>
<main>
    <section class="container">
      <div class="row py-5 align-items-center">
        <div class="col-lg-4">
            <h1 class="fw-bold mb-5 ">Istrazite svet sa nama</h1>
            <p class="fs-4">Hodanje je najsavršeniji oblik kretanja za osobu koja želi da otkrije pravi život. – Thoreau. . </p>
        </div>
        <div class="col-lg-7 ms-auto">
            <img src="assets/img/photo-1458442310124-dde6edb43d10.jpg" alt="" class="img-fluid">
        </div>
      </div>
    </section>
    <section class="container mb-5">
        <h2 class="mb-4">Izdvajamo iz ponude</h2>
        <div class="row">
            <?php foreach($getTours as $tour):?>
            <div class="col-lg-3">
            <div class="card h-100">
                <img src="assets/img/<?=$tour->image_path?>" class="card-img-top" alt="<?=$tour->name?>">
                <div class="card-body text-center">
                    <h5 class="card-title">
                        <a  href="index.php?page=tour&id=<?=$tour->id?>" class="nav-link"><?=$tour->name?></a>
                    </h5>
                </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </section>
</main>