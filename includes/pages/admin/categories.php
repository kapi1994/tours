<?php 
  if(!isset($_SESSION['user']) || isset($_SESSION['user']) && $_SESSION['user']->role_id != 1)
  header("Location: index.php?page=errors&code=403");

    $categories = getAllCategories();
?>
<main> 
    <section class="container">
        <div class="row mt-5">
            <div id="category_response_message" class="mb-2"></div>
            <div class="col-lg-8 mb-2 mb-lg-0">
                <div class="table-responsive-sm table-responsive-md">
                    <table class="table text-center align-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Updated at</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody id="categories">
                            <?php foreach($categories as $index => $category):?>
                                <tr id="category_<?=$index?>">
                                    <th scope="row"><?=$index + 1?></th>
                                    <td><?=$category->name?></td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($category->created_at));?></td>
                                    <td><?= $category->updated_at != null ? date("d/m/Y H:i:s",strtotime($category->updated_at)) : "-"?></td>
                                    <td><button class="btn btn-sm btn-success btn-edit-category" type="button" data-id="<?=$category->id?>" data-index="<?=$category->id?>">Edit</button></td>
                                    <td><button class="btn btn-sm btn-danger btn-delete-category" type="button" data-id="<?=$category->id?>" data-index="<?=$index?>" data-status="<?=$category->is_deleted?>"><?=$category->is_deleted == 0 ? 'Delete' : 'Activate'?></button></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <form action="#">
                    <input type="hidden" name="category_id" id="category_id">
                    <input type="hidden" name="category_index" id="category_index">
                    <div class="mb-3">
                        <label for="name" class="mb-1">Name</label>
                        <input type="text" name="name" id="name" class="form-control mb-1">
                        <div id="name_error"></div>
                    </div>
                    <div class="d-grid gap-1">
                        <button class="btn btn-sm btn-primary" id="btnSaveCategory" name="btnSaveCategory" type="button">Save</button>
                        <button class="btn btn-sm btn-danger" id="btnResetCategory" name="btnResetCategory" type="btnResetCategory">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>