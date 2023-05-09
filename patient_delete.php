<?php 
require('connection_bd.php');
$id = $_GET['id'];
$sql = "DELETE from patient where patientID=:patientID";
$statement = $connection -> prepare($sql);
$statement -> execute([':patientID'=>$id]);
if($statement){
    header('location:view.php?msg=Pation deleted successfully');
}
