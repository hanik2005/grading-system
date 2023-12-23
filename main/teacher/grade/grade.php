<?php
session_start();
require_once('../../db_conn.php');

if(isset($_POST['submit'])){
    $teacherStrand = (isset($_SESSION['teacherStrand'])) ? htmlspecialchars($_SESSION['teacherStrand']) : 'teacher strand not set';
    $teacherSection = (isset($_SESSION['teacherSection'])) ? htmlspecialchars($_SESSION['teacherSection']) : "teacher section not set";
    $teacherGradeLevel = (isset($_SESSION['teacherGrdlvl'])) ? htmlspecialchars($_SESSION['teacherGrdlvl']) : "teacher grade level not set";
    $teacherFname = (isset($_SESSION['teacherFname'])) ? htmlspecialchars($_SESSION['teacherFname']) : "teacher Fname not set";
    $teacherLname = (isset($_SESSION['teacherLname'])) ? htmlspecialchars($_SESSION['teacherLname']) : "teacher Lname not set";
    $teacherFullName = $teacherFname. ' ' . $teacherLname; 
    $studSection = $teacherSection;
// Define an empty array to store POST values
$postData = array();
$sem = $_POST['sem'];
$quarter = $_POST['q'];
$currentSem = ($sem==1) ? 1 : 2;
$semGradeTable = "sem$currentSem". "_grades";
$userToken = $_POST['token'];

// Loop through each POST value and store it in the array
foreach ($_POST as $key => $value) {

    // You may want to sanitize or validate the data before storing it
    // For example, you can use htmlspecialchars to prevent HTML injection
    $postData[$key] = htmlspecialchars($value);
}
print_r($postData);
$grades = implode(",",$postData);
echo $grades;
$removeToken = removeFromString($grades, $userToken);
$removeSem = removeFromString($removeToken, $sem);
$removeSubmit = removeFromString($removeSem, $_POST['submit']);
$grades = removeFromString($removeSubmit, $quarter);

if($quarter == 1 && $sem == 1) {
    $stmt = $conn->prepare("UPDATE students SET firstQr_grades = :grades WHERE token=:token");
$stmt->execute([
   ":grades"=>$grades,
   ':token'=> $userToken
]);
if($stmt->rowCount() > 0) {
   echo "update success 1st";
} else  {
   echo "update failed 1st";
  }
} else if($quarter == 2 && $sem == 1) {
    $stmt = $conn->prepare("UPDATE students SET secondQr_grades = :grades WHERE token=:token");
$stmt->execute([
   ":grades"=>$grades,
   ':token'=> $userToken
]);
if($stmt->rowCount() > 0) {
   echo "update success 2nd";
} else  {
   echo "update failed 2nd";
  }
}else if($quarter == 3 && $sem == 2) {
    $stmt = $conn->prepare("UPDATE students SET thirdQr_grades = :grades WHERE token=:token");
$stmt->execute([
   ":grades"=>$grades,
   ':token'=> $userToken
]);
if($stmt->rowCount() > 0) {
   echo "update success 3rd";
} else  {
   echo "update failed 3rd";
  }
}else if($quarter == 4 && $sem == 2) {
    $stmt = $conn->prepare("UPDATE students SET fourthQr_grades = :grades WHERE token=:token");
$stmt->execute([
   ":grades"=>$grades,
   ':token'=> $userToken
]);
if($stmt->rowCount() > 0) {
   echo "update success 4th";
} else  {
   echo "update failed 4th";
  }
}

}
function removeFromString($str, $item) {
    $parts = explode(',', $str);

    while(($i = array_search($item, $parts)) !== false) {
        unset($parts[$i]);
    }

    return implode(',', $parts);
}
function getQ1($conn, $userToken){
 $stmt= $conn->prepare("SELECT sem1_grades FROM students WHERE token=:userToken");
 $stmt->execute([
    ":userToken"=>$userToken
 ]);
 $result = $stmt->fetch(PDO::FETCH_ASSOC);
 if($stmt->rowCount()>0){
  return $result['sem1_grades'];
 }else{
    return "User not Found";
 }
}
function deleteSem1($conn, $userToken){
    $stmt = $conn->prepare("UPDATE students SET sem1_grades=NULL ");
    $stmt->execute();
}




?>