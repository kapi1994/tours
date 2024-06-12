<?php
    $getAvailableCateories = getAvailableCategories();
    $getAvailableTours = getAvailableTours();
    $toursPagination = getAvaliableToursPagination();
?>
<main>
  <section class="container">
    <div class="row mt-5">
        <div id="tour_response_message" class="mb-2"></div>
        <div class="col-lg-3">
           <input type="text" class="form-control mb-2" id="search_text">
            <div class="mb-2">
                <label for="cateory" class="mb-1 fw-bold">Categories</label>
                <?php foreach($getAvailableCateories as $category):?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?=$category->id?>" id="check_<?=$category->id?>" name="categories">
                        <label class="form-check-label" for="check_<?=$category->id?>">
                           <?=$category->name?>
                        </label>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row " id="tours">
                <?php foreach($getAvailableTours as $tour):?>
                    <div class="col-lg-3 mb-2">
                        <div class="card h-100">
                            <img src="assets/img/<?=$tour->image_path?>" class="card-img-top" alt="<?=$tour->name?>">
                            <div class="card-body text-center">
                              <h2 class="fs-5">  <a href="index.php?page=tour&id=<?=$tour->id?>" class="nav-link"><?=$tour->name?></a></h2>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
            <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination" id="pages-tours">
                        <?php for($i =0 ;$i<$toursPagination;$i++):?>
                             <li class="page-item"><a data-limit = '<?=$i?>' class="page-link page-tours <?=$i == 0  ? 'active' : ''?>" href="#"><?=$i+1?></a></li>
                        <?php endfor;?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
  </section>
</main>