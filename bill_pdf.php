<?php
session_start();
if(!isset($_SESSION['password'])){
    header('location:login.php');
}else{

?>
<?php
require('config.php');
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>

<body>
    <?php
    require_once('inc/header.php')
    ?>
    <img src="images/10130.jpg" class="rounded float-start" alt="" width="300px">
    <img src="images/cmc.jpg" class="rounded float-end " alt="" width="200px">
    <div class="container col-7">

        <table class="table">
            <?php
            $sql = "SELECT p.*, GROUP_CONCAT(s.nom SEPARATOR '<br>') as specialites
            FROM patient p
            JOIN consultation c ON p.patientID = c.patientID
            JOIN specialite s ON c.specialiteID = s.specialiteID
            WHERE p.patientID = :id
            LIMIT 1";

            $statement = $connection->prepare($sql);
            $statement->execute([':id' => $id]);
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            ?>
            <tr>
                <th>Nom</th>
                <td><?php echo $row['nom']; ?></td>
            </tr>
            <tr>
                <th>Sexe</th>
                <td><?= $row['sexe'] ?></td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td><?= $row['num_tel'] ?></td>
            </tr>
            <tr>
                <th>Specialities</th>
                <td><?= $row['specialites'] ?></td>
            </tr>
            <tr>
                <th>Prix totale</th>
                <td><?= (substr_count($row['specialites'], "<br>") + 1) * 300 ?> DH</td>
            </tr>
            <tr>

                <td class="d-flex justify-content-center ">
                    <a href="downloadpdf.php?id=<?= $id; ?>" class="btn btn-success">Download &nbsp <i class="fa fa-download"></i></a>
                </td>
            </tr>
        </table>
    </div>
    <div>
        <table>
            <th>Date d'edition</th>
            <td> &nbsp <?= date("d/m/Y") ?></td>
        </table>
    </div>
    <img src="images/qrcode.png" class="rounded float-start" alt="" width="150px">
    <img src="images/cachet.png" class="rounded float-end " alt="" width="150px">
</body>

</html>
<?php  }?>