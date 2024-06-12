<?php 

if(!isset($_SESSION['user']) || isset($_SESSION['user']) && $_SESSION['user']->role_id != 1)
header("Location: index.php?page=errors&code=403");

$categories = getAvailableCategories();
$tours = getAllTours();
$pagination = getAllToursPagination();
?>
<main>
    <section class="container">
        <div class="row mt-5">
            <div class="mb-2" id="tour_response_message"></div>
            <div class="col-lg-8 mb-2 mb-g-0">
                <div class="table-responsive-sm table-responsive-md">
                    <table class="table text-center align-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Naziv</th>
                                <th scope="col">Cena</th>
                                <th scope="col">Broj dana</th>
                                <th scope="col">Kategorije</th>
                                <th scope="col">Dodaj termine</th>
                                <th scope="col">Datum kreiranja</th>
                                <th scope="col">Datum izmene</th>
                                <th scope="col">Izmeni</th>
                                <th scope="col">Obrisi</th>
                            </tr>
                        </thead>
                        <tbody id="tours">
                            
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination" id="tour-pages">
                            
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-lg-4">
                <form action="#">
                    <input type="hidden" name="tour_index" id="tour_index">
                    <input type="hidden" name="tour_id" id="tour_id">
                    <div class="mb-3">
                        <label for="name" class="mb-1">Naziv</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <div id="name_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="price"class='mb-1'>Cena</label>
                        <input type="number" name="price" id="price" class="form-control mb-1">
                        <div id="price_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="mb-1">Slika</label>
                        <input type="file" name="image" id="image" class="form-control">
                        <div id="image_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="mb-1">Trajanje (u danima)</label>
                        <input type="number" name="duration" id="duration" class="form-control">
                        <div id="duration_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="mb-1">Kategorija</label>
                        <div class="row">
                            <?php foreach($categories as $category):?>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?=$category->id?>" id="category_<?=$category->id?>" name="categories">
                                    <label class="form-check-label" for="category_<?=$category->id?>">
                                      <?=$category->name?>
                                    </label>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                        <div id="category_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="short_descrption" class="mb-1">Kratak opis</label>
                        <textarea name="short_descption" id="short_description" class="form-control mb-1"></textarea>
                        <div id="short_description_error"></div>
                    </div>
                   <div class="mb-3" >
                        <label for="tour_description" class="mb-1">Opis putovanja</label>
                        <textarea name="tour_description" id="tour_description" class="form-control"></textarea>
                        <div id="tour_desciption_error"></div>
                   </div>
                    <div class="mb-3">
                        <img src="" alt="" id="tour_img" class="d-none">  
                    </div>
                   <div class="d-grid gap-1">
                            <button class="btn btn-sm btn-primary" id="btnSaveTour" type="button">Save</button>
                            <button class="btn btn-sm btn-danger" id="btnResetTour" type="button">Reset</button>
                   </div>
                </form>
            </div>
        </div>
    </section>
</main>