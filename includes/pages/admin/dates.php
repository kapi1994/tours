<?php 

    if(!isset($_SESSION['user']) || isset($_SESSION['user']) && $_SESSION['user']->role_id != 1)
        header("Location: index.php?page=errors&code=403");

    $id =$_GET['id'];
    $tourName = getTourName($id);
    $dates= getTourDates($id);

?>
<main>
    <section class="container">
        <div class="row mt-5">
            <div class="col mb-3" id="date_response_message"></div>
        </div>
        <div class="row mt-2">
            <h2><?=$tourName->name?></h2>
            <hr>
            <div class="col-lg-8 mb-2 mb-lg-0">
                <div class="table-responsive-sm table-responsive-md">
                    <table class="table text-center align-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Datum polaska</th>
                                <th scope="col">Datum kreiranja</th>
                                <th scope="col">Datum izmene</th>
                                <th scope="col">Izmeni</th>
                                <th scope="col">Izbrisi</th>
                            </tr>
                        </thead>
                        <tbody id="dates">
                            <?php foreach($dates as $index => $date):?>
                                <tr id="date_<?=$index?>">
                                    <th scope="row"><?=(int)$index +1?></th>
                                    <td><?=date("d/m/Y", strtotime($date->date))?></td>
                                    <td><?= date("d/m/Y H:i:s", strtotime($date->created_at))?></td>
                                    <td><?= $date->updated_at != null ? date("d/m/Y H:i:s", strtotime($date->updated_at)):"-"?></td>
                                    <td><button class="btn btn-sm btn-success btn-edit-date" type="button" data-id="<?=$date->id?>" data-index="<?=$index?>">Edit</button></td>
                                    <td><button class="btn btn-sm btn-danger btn-delete-date" type='button' data-id="<?=$date->id?>" data-index="<?=$index?>" data-status="<?=$date->is_deleted?>"><?=$date->is_deleted == 0 ? "Delete" :"Activate"?></button></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <input type="hidden" name="tour_id" id="tour_id" value="<?=$id?>">
                <input type="hidden" name="date_index" id="date_index">
                <input type="hidden" name="date_id" id="date_id">
                <div class="mb-3">
                    <label for="date" class="mb-1">Date</label>
                    <input type="date" name="date" id="date" class="form-control" class="mb-1">
                    <div id="date_error"></div>
                </div>
                <div class="d-grid gap-1">
                    <button class="btn btn-sm btn-primary" id="btnSaveDate" type="button">Save</button>
                    <button class="btn btn-sm btn-danger" id="btnResetDate" type="button">Reset</button>
                </div>
            </div>
        </div>
    </section>
</main>