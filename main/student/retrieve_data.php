<?php
 session_start();
 require_once ("../db_conn.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
if(isset($_POST['teacherInfo'])){
    echo json_encode($_SESSION);
   }
   if(isset($_POST['studentInfo'], $_POST['studentToken'])){
    $studToken = $_POST['studentToken'];
    $stmt = $conn->prepare("SELECT * FROM students WHERE token=:token");
    $stmt->execute([
        ":token"=>$studToken
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($stmt->rowCount()>0){
        $gradesArray = [];
        $studentGradeArrayQuarter1 = explode(",", $result['firstQr_grades']);
        $studentGradeArrayQuarter2 = explode(",", $result['secondQr_grades']);
        $studentGradeArrayQuarter3 = explode(",", $result['thirdQr_grades']);
        $studentGradeArrayQuarter4 = explode(",", $result['fourthQr_grades']);
        array_push($gradesArray, $studentGradeArrayQuarter1, $studentGradeArrayQuarter2, $studentGradeArrayQuarter3, $studentGradeArrayQuarter4);
        echo json_encode($gradesArray);
    }else{
        echo "error fetching student";
    }
   }
}


?>