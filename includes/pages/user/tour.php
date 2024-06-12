<?php 
$id = $_GET['id'];
$tourDates = '';
$tourData = getTourData($id);

$tourDates = getAvailableTourDate($id);
$getQuestion = getAvailableQuestion();

$getAnswers = getSurveyOptions($getQuestion->id);
if(isset($_SESSION['user'])){
    $checkVote = checkIfUserVote($_SESSION['user']->id, $getQuestion->id);
}
?>
<main>
    <section>
        <div class="container">
            <div class="row mt-5">
                <div id="tour_reservation_response_message"></div>
                <div class="<?=isset($_SESSION['user']) ? 'col-lg-6 mx-auto mb-2 mb-lg-0 ' : 'col-lg-6 mx-auto'?>">
                    <img src="assets/img/<?=$tourData->image_path?>" alt="" class="img-fluid mb-3">
                    <h2 class="mb-3"><?= $tourData->name?></h2>
                    <p class="lh-base fs-6"><?=$tourData->short_description?></p>
                    <?=$tourData->long_description?>
                </div>
             
                <div class="col-lg-4 ms-auto">
                    
                    <p class="fs-3 fw-bold">Cena: <span class="ms-2 text-danger"><?=$tourData->price?></span></p>
                    <p class="fs-3">Broj dana: <span class="ms-2"><?=$tourData->days?></span></p>
                    <p class="fs-3 fw-bold">Termini:</p>
                    <?php foreach($tourDates as $index => $tourDate):?>
                        <span class="fs-4"><?= array_key_last($tourDates) !== $index ? date('d/m', strtotime($tourDate->date)).',' : date('d/m', strtotime($tourDate->date))?></span>
                    <?php endforeach;?>
                    <?php if(isset($_SESSION['user'])):?>
                    <p class="fs-3 mt-3 fw-bold">Rezervacije</p>
                   
                  
                    <form action="#">
                        <input type="hidden" name="tour_id" id="tour_id" value="<?=$id?>">
                        <div class="mb-3">
                            <label for="date" class="mb-1">Odaberite datum polaska</label>
                            <select name="date" id="date" class="form-select">
                                <option value="0">Datum polaska</option>
                                <?php foreach($tourDates as $tourDate):?>
                                    <option value="<?=$tourDate->id?>"><?=date('d/M/Y',strtotime($tourDate->date))?></option>
                                    <?php endforeach;?>
                            </select>
                            <div id="tour_date_error"></div>
                        </div>
                        <div class="d-grid gap-1">
                            <button class="btn btn-sm btn-primary" type="button" id="btnReserveTour">Rezervisi</button>
                        </div>
                    </form>
                    <div id ='survey'>

                                    <?php if(!$checkVote):?>
                    <p class="fs-3 my-2">Anketa</p>
                    <p class="fs-5"><?=$getQuestion->name?></p>
                    <form action="#">
                        <input type="hidden" name="survey_id" id="survey_id" value="<?=$getQuestion->id?>">
                        <div class="mb-2">
                            <?php foreach($getAnswers as $answer):?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers" id="answer_<?=$answer->answer_id?>" value="<?=$answer->answer_id?>">
                            <label class="form-check-label" for="answer_<?=$answer->answer_id?>">
                              <?=$answer->name?>
                            </label>
                            </div>
                            <?php endforeach;?>
                            <div id="vote_error"></div>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-sm btn-primary" type="button" id="btnVote">Glasaj</button>
                        </div>
                    </form>
                                    </div>
                    <?php endif;
                             endif;?>
                </div>
     
            </div>
        </div>
    </section>
</main>