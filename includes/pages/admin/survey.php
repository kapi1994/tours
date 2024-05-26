<?php 
    $questions = getAllQuestions();
    $answers = getAllAnswers();
    $surveys = getAllSurveys();
?>
<main>
    <section class="container">
     
        <div class="row mt-5">
            <div id="survey_message" class="mb-2"></div>
            <div class="col-lg-3 mb-2 mb-lg-0">
                <div class="d-grid"><a href="admin.php?page=add-question" class="btn btn-sm btn-primary">Add question</a></div>
            </div>
            <div class="col-lg-3">
                <div class="d-grid"><a href="admin.php?page=add-answer" class="btn btn-sm btn-primary">Add a answer</a></div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-8 mb-2 mb-lg-0">
                    <div class="table-responsive-sm table-responsive-md">
                        <table class="table text-center align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Question</th>
                                    <th scope="col">Exire at</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">Updated at</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="surveys">
                                <?php foreach($surveys as $index => $survey):?>
                                    <tr id="survey_<?=$index?>">
                                        <th scope="row"><?=$index + 1?></th>
                                        <td><?=$survey->questionName?></td>
                                        <td><?= date("d/m/Y", strtotime($survey->expire_date))?></td>
                                        <td><?= date("d/m/Y H:i:s", strtotime($survey->created_at))?></td>
                                        <td><?= $survey->updated_at != null ? date("d/m/Y H:i:s", strtotime($survey->updated_at)) : "-"?></td>
                                        <td><button class="btn btn-sm btn-success btn-edit-survey"
                                        type="button" data-id="<?=$survey->id?>" data-index="<?=$index?>">Edit</button></td>
                                        <td>
                                            <button class="btn btn-sm btn-danger btn-delete-survey"
                                            type="button" data-id="<?=$survey->id?>" data-index="<?=$index?>"
                                            data-active="<?=$survey->is_active?>"><?=$survey->is_active == 1 ? "Delete" : "Activate"?></button>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                   <form action="#">
                        <input type="hidden" name="survey_id" id="survey_id">
                        <input type="hidden" name="survey_index" id="survey_index">
                        <div class="mb-3">
                            <label for="date" class="mb-1">Date</label>
                            <input type="date" name="date" id="date" class="form-control mb-1">
                            <div id="date_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="question" class="mb-1">Question</label>
                            <select name="question" id="question" class="form-select">
                                <option value="0">Izaberite</option>
                                <?php foreach($questions as $question):?>
                                    <option value="<?=$question->id?>"><?=$question->name?></option>
                                <?php endforeach;?>
                            </select>
                            <div id="question_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="answers" class="mb-1">Answers</label>
                            <?php foreach($answers as $answer):?>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" value="<?=$answer->id?>" id="answer_<?=$answer->id?>" name="answers">
                                <label class="form-check-label" for="answer_<?=$answer->id?>">
                                    <?=$answer->name?>
                                </label>
                            </div>
                            <?php endforeach;?>
                            <div id="answer_error"></div>
                        </div>
                        <div class="d-grid gap-1">
                            <button class="btn btn-sm btn-primary" id="btnSaveSurvey" name="btnSaveSurvey" type="button">Save</button>
                            <button class="btn btn-sm btn-danger" id="btnResetSurvey" name="btnResetSurvey" type="button">Reset</button>
                        </div>
                   </form>
                </div>
            </div>
    </section>
</main>