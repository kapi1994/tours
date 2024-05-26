<?php 
  if(!isset($_SESSION['user']) || isset($_SESSION['user']) && $_SESSION['user']->role_id != 1)
    header("Location: index.php?page=errors&code=403");
  $answers = getAllAnswers();
?>
<main>
    <section class="container">
        <div class="row mt-5">
            <div id="answer_response_message" class="mb-2"></div>
            <div class="col-lg-8 mb-2 mb-lg-0">
                <div class="table-responsive-sm table-responsive-md">
                    <table class="table text-center align-middle">
                        <thead>
                            <trh>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Updated at</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </trh>
                        </thead>
                        <tbody id="answers">
                            <?php foreach($answers as $index=>$answer):?>
                                <tr id="answer_<?=$index?>">
                                    <th scope="row"><?=$index + 1?></th>
                                    <td><?= $answer->name?></td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($answer->created_at))?></td>
                                    <td><?= $answer->updated_at != null ? date("d/m/Y H:i:s", strtotime($answer->updated_at)):"-"?></td>
                                    <td><button class="btn btn-sm btn-success btn-edit-answer" type="button" data-id="<?=$answer->id?>" data-index="<?=$index?>">Edit</button></td>
                                    <td><button class="btn btn-sm btn-danger btn-delete-answer" type="button" data-id ="<?=$answer->id?>" data-index="<?=$index?>" data-status="<?=$answer->is_deleted?>"><?= $answer->is_deleted == 0 ? "Delete" : "Activate"?></button></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <form action="#">
                    <input type="hidden" name="answer_id" id="answer_id">
                    <input type="hidden" name="answer_index" id="answer_index">
                    <div class="mb-3">
                        <label for="answer" class="mb-1">Answer</label>
                        <input type="text" name="answer" id="answer" class="form-control mb-1">
                        <div id="answer_error"></div>
                    </div>
                    <div class="d-grid gap-1">
                        <button class="btn btn-sm btn-primary" id="btnSaveAnswer" type="button" name="btnSaveAnswer">Save</button>
                        <button class="btn btn-sm btn-danger" id="btnResetAnswer" type="button" name="btnResetAnswer">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>