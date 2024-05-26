<?php
    if(!isset($_SESSION['user']) || isset($_SESSION['user']) && $_SESSION['user']->role_id != 1)
    header("Location: index.php?page=errors&code=403");
    $questions = getAllQuestions();
?>
<main>
    <section class="container">
        <div class="row mt-5">
            <div id="question_response_message" class="mb-2"></div>
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
                        <tbody id="questions">
                            <?php foreach($questions as $index => $question) :?>
                            <tr id="question_<?=$index?>">
                                <th scope="row"><?=$index + 1?></th>
                                <td><?=$question->name?></td>
                                <td><?=date('d/m/Y H:i:s', strtotime($question->created_at));?></td>
                                <td><?= $question->updated_at != null ? date('d/m/Y H:i:s', strtotime($question->updated_at)) : '-'?></td>
                                <td><button class="btn btn-sm btn-success btn-edit-question" type="button" data-id="<?=$question->id?>" data-index="<?=$index?>">Edit</button></td>
                                <td><button class="btn btn-sm btn-danger btn-delete-question"
                                    type="button" data-index="<?=$index?>" data-status = "<?=$question->is_deleted?>" data-id="<?=$question->id?>"
                                ><?=$question->is_deleted == 0 ? "Delete" : "Activate"?></button></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <form action="#">
                    <input type="hidden" name="question_index" id="question_index">
                    <input type="hidden" name="question_id" id="question_id">
                    <div class="mb-3">
                        <label for="question" class="mb-1">Question</label>
                        <input type="text" name="question" id="question" class="form-control">
                        <div id="question_error"></div>
                    </div>
                    <div class="d-grid gap-1">
                        <button class="btn btn-sm btn-primary" id="btnSaveQuestion" type="button" name="btnSaveQuestion">Save</button>
                        <button class="btn btn-sm btn-danger" id="btnResetQuestion" type="reset" name="btnResetQuestion">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>