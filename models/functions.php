<?php 
// global 

define("ADMIN_OFFSET",5);
define("USER_OFFSET",12);

function getOne($query){
    global $connection;
    return $connection->query($query)->fetch();
}

function getAll($query){    
    global $connection;
    return $connection->query($query)->fetchAll();
}

function changeStatus($table, $status, $id){
    global $connection;
    $status = $status == 0 ? 1 : 0;
    $query = "update $table set is_deleted = ?  where id =?";
    $update = $connection->prepare($query);
    $update->execute([$status, $id]);
}

function checkEmail($email){
    global $connection;
    return $connection->query("select id from users where email = '$email'")->fetch();
    
}

function checkAccount($email, $password){
    global $connection;
    $query = "select id, role_id from users where email = ? and password = ?";
    // select id, role_id from users where email = ? and password = ?
    $result = $connection->prepare($query);
    $result->execute([$email, md5($password)]);
    return $result->fetch();
}

function createNewAccount($first_name, $last_name, $email, $password){
    global $connection;
    define("USER_ROLE_ID",2);
    $query = "insert into users (first_name, last_name, email, password, role_id) values(?,?,?,?,?)";
    $insert = $connection->prepare($query);
    $insert->execute([$first_name, $last_name, $email, md5($password), (int)USER_ROLE_ID]);
}

// categories
function getAllCategories(){
return getAll('select * from categories');}

function getOneCategory($id){
    return getOne("select id, name from categories where id ='$id'");
}

function getOneCategoryFullRow($id){
    return getOne("select * from categories where id ='$id'");
}
function checkCategoryName($name){
    return getOne("select id, name from categories where name ='$name'");
}
function storeNewCategory($name){
    global $connection;
    $query = "insert into categories (name) values(?)";
    $insert = $connection->prepare($query);
    $insert->execute([$name]);
}

function updateCategory($id, $name){
    global $connection;
    $date = date("Y-m-d H:i:s");
    $query = "update categories set name =? , updated_at =? where id = ?";
    $update = $connection->prepare($query); 
    $update->execute([$name, $date, $id]);
}

// tours
function getAvailableCategories(){  
return getAll("select id, name from categories");

}

function getAllTours($limit = 0){
    $queryTours = "select * from tours";
    
    $offset = (int) ADMIN_OFFSET;
    $limit = (int)$limit * $offset;
    $queryLimit = " limit $limit, $offset";
    $queryTours.= $queryLimit;
    $tours = getAll($queryTours);
    foreach($tours as $tour){
        $queryCategory = "select name from categories
        c join category_tour ct on c.id = ct.category_id
        where ct.tour_id = $tour->id";
        $tour->categories = getAll($queryCategory);
    }
    return $tours;
}

function getAllToursPagination(){
    $query = "select count(*) as numberOfElements from tours";
    $data = getOne($query);
    return ceil($data->numberOfElements / ADMIN_OFFSET);
}

function getOneTour($id){
    $query = "select id, name, short_description, long_description, image_path, days, price from tours where id ='$id'";
    $tour = getOne($query);
    $categoryQuery ="select category_id from category_tour where tour_id='$id'";
    $tour->categories = getAll($categoryQuery);
    return $tour;
}


function getOneTourFullRow($id){
    $query = "select id, name,  days, price, created_at, updated_at, is_deleted from tours where id ='$id'";
    $tour = getOne($query);
    $categoryQuery ="select name from category_tour ct join categories c on ct.category_id = c.id where ct.tour_id='$id'";
    $tour->categories = getAll($categoryQuery);
    return $tour;
}

function checkTourName($name){
    $query = "select id, name from tours where name = '$name'";
    return getOne($query);
}

function insertTour($name, $short_description, $long_description, $image, $days, $price, $categories){
    global $connection;
    $queryInsert = "insert into tours (name, short_description, long_description, image_path, days, price ) values(?,?,?,?,?,?)";
    $insert = $connection->prepare($queryInsert);
    $insert->execute([$name, $short_description, $long_description, $image, $days, $price]);
    $id = $connection->lastInsertId();
    insertIntoPivotTable('category_tour', 'category_id','tour_id', $categories, $id);

}

function updateTour($name, $shortDescription, $longDescription, $days, $price, $categories, $id, $image = ""){
     global $connection;
     $date = date("Y-m-d H:i:s");
     $query = "update tours set name  = ?, short_description  = ?, long_description  = ?,  ";
     $dataArray = [];
     array_push($dataArray, $name);
     array_push($dataArray, $shortDescription);
     array_push($dataArray, $longDescription);
     
     if($image != ""){
        $query.= "image_path = ?,";
        array_push($dataArray, $image);
     }
     $query.= "days =? , price =?, updated_at =? where id =?"; 
    
     array_push($dataArray, $days);
     array_push($dataArray, $price);
     array_push($dataArray, $date);
     array_push($dataArray, $id);
     $data = $connection->prepare($query);
     $data->execute($dataArray);
     deleteData('category_tour','tour_id', $id);
     insertIntoPivotTable('category_tour', 'category_id','tour_id', $categories, $id);
     
     
}

function insertIntoPivotTable($table, $columnOne, $columnTwo, $valueArray, $id){
    global $connection;
    $params = [];
    $values = [];
    foreach($valueArray as  $value){
        $params[] = "(?,?)";
        $values[] = $value;
        $values[] = $id;
    }
    $queryInsert = "insert into $table ($columnOne, $columnTwo) values".implode(',', $params);
    $insert = $connection->prepare($queryInsert);
    $insert->execute($values);
}

function deleteData($table, $columnWhere, $columnData){
    global $connection;
    $query = "delete from $table where $columnWhere = ?";
    $delete = $connection->prepare($query);
    $delete->execute([$columnData]);
}

// dates
function getTourName($tour_id){
    return getOne("select name from tours where id ='$tour_id'");
}
function getTourDates($tour_id){
    return getAll("select * from tour_dates where tour_id = '$tour_id'");
}
function getOneDate($id){
    return getOne("select id, date from tour_dates where id = '$id'");
}
function getOneDateFullRow($id){
    return getOne("select * from tour_dates where id = '$id'");
}
function checkTourDate($date, $tour_id){
    $query = "select id, date, tour_id from tour_dates where tour_id= '$tour_id' and date= '$date'" ;
    return getOne($query);          
}

function insertTourDate($date, $tour_id){
    global $connection;
    $query = "insert into tour_dates (tour_id, date) values(?,?)";
    $insert = $connection->prepare($query);
    $insert->execute([$tour_id, $date]);
}

function updateTourDate($date, $id){
    global $connection;
    $date_update= date("Y-m-d H:i:s");
    $queryUpdate = "update tour_dates set  date = ?, updated_at  = ? where id =?";

    $update = $connection->prepare($queryUpdate);
    $update->execute([$date, $date_update, $id]);
}


// questions
function getAllQuestions(){
    return getAll('select * from questions');
}

function getOneQuestion($id){
    return getOne("select id, name from questions where id ='$id'");
}

function getQuestionFullRow($id){
    return getOne("select * from questions where id ='$id'" );
}

function checkQuestion($name){
    return getOne("select id, name from questions where name = '$name'");
}

function insertQuestion($name){
    global $connection;
    $query = "insert into questions (name) values(?)";
    $insert = $connection->prepare($query);
    $insert->execute([$name]);
}

function updateQuestion($name, $id){
    global $connection;
    $date = date("Y-m-d H:i:s");
    $query = "update questions set name =?, updated_at =? where id = ?";
    $update = $connection->prepare($query);
    $update->execute([$name, $date, $id]);
}

// messages
function storeNewMessage($first_name, $last_name, $email, $message){
    global $connection;
    $query = "insert into messages (first_name, last_name, email, message)
        values (?,?,?,?)";
    $insert = $connection->prepare($query);
    $insert->execute([$first_name, $last_name, $email, $message]);
}

function getAllMessages($limit = 0){
   $baseQuery = "select * from messages";
   $orderBy = " ORDER BY created_at desc";
   $offset = (int)ADMIN_OFFSET;
   $limit = (int)$limit *  $offset;
   $queryLimit = " limit $limit, $offset";
  
   $query = $baseQuery.$orderBy.$queryLimit;
   return getAll($query);
}

function messagePagination(){
    $query = "select count(*) as numberOfElements from messages";
    $elements = getOne($query);
    return ceil($elements->numberOfElements/ADMIN_OFFSET);
}


function getOneMessage($id){
    return getOne("select first_name, last_name, email, message, created_at from messages where id ='$id'");
}



// answers

function getAllAnswers(){
    return getAll('select * from answers');
}

function getOneAnswer($id){
    return getOne("select id, name from answers where id ='$id'");
}

function getAnswerFullRow($id){
    return getOne("select * from answers where id ='$id'");
}

function checkAnswers($name){
    return getOne("select id, name from answers where name = '$name'");
}

function insertNewOption($name){
    global $connection;
    $query="insert into answers (name) values(?)";
    $insert = $connection->prepare($query);
    $insert->execute([$name]);
}

function updateOption($name, $id){
    global $connection;
    $date = date("Y-m-d H:i:s");
    $query = "update answers set name =?, updated_at =? where id =?";
    $update= $connection->prepare($query);
    $update->execute([$name, $date,$id]);
}   

// survy
function getAvailableQuestions(){
    $query = "select id, name from questions where is_deleted = 0";
    return getAll($query);
}

function getAvailableAnswers(){
    $query = "select id, name from answers where is_deleted =0";
    return getAll($query);
}

function checkActiveSurvey(){
    $query = "select * from survey where is_active = 1";
    return getAll($query);
}

function updateStatusSurvey(){
    global $connection;
    $is_active = 0;
    $query = "update survey set is_active = ?";
    $udpateQuery = $connection->prepare($query);
    $udpateQuery->execute([$is_active]);
}

function insertSurvey($date, $question, $answers){
    global $connection;
    if(checkActiveSurvey()){
        updateStatusSurvey();
    }else{
        $query = "insert into survey (expire_date, question_id) values(?,?)";
        $insert = $connection->prepare($query);
        $insert->execute([$date, $question]);
        $last_id = $connection->lastInsertId();
        insertIntoSurveyAnswer($last_id, $answers);
    }
}

function insertIntoSurveyAnswer($survey_id, $answers){
    global $connection;
    $query = "insert into survey_answers (survey_id, answer_id)";
    $surveyParam = [];
    $surveyValues = [];
    foreach($answers as $answer){
        $surveyParam[]= "(?,?)";
        $surveyValues[]=  (int)$survey_id;    
        $surveyValues[] = (int)$answer;
    }
    $query.= " values".implode(',',$surveyParam);
    $insert = $connection->prepare($query);
    $insert->execute($surveyValues);
}

function getAllSurveys(){
    return getAll('select  s.*, q.name as questionName 
    from survey s join questions q on s.question_id = q.id');
}

function getOneSurvey($survey_id){
    $query = "select id, question_id, expire_date from survey where id= '$survey_id'";
    $survey  = getOne($query);
    $surveyOptionsQuery = "select answer_id from survey_answers where survey_id = '$survey->id'";
    $survey->answers = getAll($surveyOptionsQuery);
    return $survey;
}

function updateSurvey($survey_id, $date, $question, $answers){
    global $connection;
    $update_date = date("Y-m-d H:i:s");
    $queryUpdate = "update survey set expire_date = ? , question_id = ?, updated_at =? 
        where id = ?";
    $update = $connection->prepare($queryUpdate);
    $update->execute([$date, $question, $update_date, $survey_id]);
    deleteData('survey_answers', 'survey_id', $survey_id);
    insertIntoSurveyAnswer($survey_id, $answers);
}

function getSurveyOneFullRow($id){
    return getOne("select  s.*, q.name as questionName 
    from survey s join questions q on s.question_id = q.id where s.id = '$id'");
}

function checkIfIsAnyActive(){
    $query = "select count(*) as numberOfSurveys from survey where is_active = 1";
    return getOne($query);
}

function changeStatusSurvey($id, $status){
    global $connection;
    $status = $status == 1 ? 0 : 1;
    $query = "update survey set is_active =? where id =?";
    $update = $connection->prepare($query);
    $update->execute([$status, $id  ]);
}

   
// others 
function numberOfRegistretedUsers(){
    $query = "select count(*) as numberOfUsers from users where role_id = 2";
    return getOne($query);
}
function numberOfTours(){
    $query  = "select count(*) as numberOfTours from tours where is_deleted = 0";
    return getOne($query);
}

//
function getAvailableTours($limit =  0,$search = '', $categories= ''){
    // SELECT * from tours t join category_tour ct on t.id = ct.tour_id where ct.category_id in (1);
    $queryWhere = " where is_deleted = 0";
    $baseQuery = "select  t.id, t.name, t.image_path from tours t ";
    if($search != ""){
        $compareString = trim("%$search%");
        $queryWhere.=" and name like '$compareString'";
    }
    if($categories != ""){
        $baseQuery.= "join category_tour ct on t.id = ct.tour_id";
        $queryWhere .= " and ct.category_id in (".$categories.")";
    }
    $offset = (int)USER_OFFSET;
    $limit = (int)$limit * $offset;
    $queryLimit = " limit $limit, $offset";
    $query = $baseQuery.$queryWhere.$queryLimit;
    // return $query;
    return getAll($query);
}

function getAvaliableToursPagination($search ="", $categories= ""){
    $baseQuery = "select count(*) as numberOfElements from tours t";
    $queryWhere = "  where is_deleted = 0";
    if($search != ""){
        $compareString = trim("%$search%");
        $queryWhere .= " and t.name like '$compareString'";
    }
    if($categories != ""){
        $baseQuery.= " join category_tour ct on t.id = ct.tour_id";
        $queryWhere .= " and ct.category_id in (".$categories.")";
    }
    $query = $baseQuery.$queryWhere;
    $data = getOne($query);
    return ceil($data->numberOfElements / USER_OFFSET);
}

function getTheMostVisitedTours(){
    $query = "select COUNT(*) as mostVisitedTours, t.name, td.date from reservations  utd join tour_dates td on utd.tour_date_id = td.id
    join tours t on td.tour_id = t.id GROUP BY tour_date_id ORDER BY mostVisitedTours DESC";
    return getAll($query);
}

// user
function getAvailableTourDate($tour_id){
    $query = "select id, date from tour_dates where is_deleted = 0 and tour_id = '$tour_id' ORDER BY date ASC";
   return getAll($query);
}

function getTourData($tour_id){
    $query = "select * from tours where id= '$tour_id'";
    return getOne($query);
}

//  nav fucntions
function getUserMenu(){
    return getAll('select * from user_menu');
}
function getAdminMenu(){
    return getAll("select * from admin_menu");
}

function storeNewReservation( $tour_date, $user_id){
    global $connection;
    $query = "insert into reservations (tour_date_id, user_id) values(?,?)";
    $insert = $connection->prepare($query);
    $insert->execute([$tour_date, $user_id]);
}

function getAvailableQuestion(){
    $query = "select s.id, q.name from survey s join questions q on s.question_id = q.id where q.is_deleted = 0";
    return getOne($query);
}

function getSurveyOptions($survey_id){
    $query ="select sa.answer_id, a.name from survey_answers sa join answers a on sa.answer_id = a.id  where sa.survey_id = '$survey_id'";
    return getAll($query);
}

function checkIfUserVote($user_id, $survey_id){
    $query ="select * from survey_vote where user_id = '$user_id' and id_survey='$survey_id'";
    return getOne($query);
}

function insertVote($survey_id, $option_id, $user_id){
    global $connection;
    $queryInsert = $connection->prepare("insert into survey_vote (id_survey, id_answer, user_id) values(?,?,?) ");
    $queryInsert->execute([$survey_id,$option_id, $user_id]);   
}

function getMainTours(){
    $baseQuery = "select  t.id, t.name, t.image_path from tours t limit 4 ";
    return getAll($baseQuery);
}