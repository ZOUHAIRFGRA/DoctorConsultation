<?php
session_start();
if(!isset($_SESSION['password'])){
    header('location:login.php');
}else{

?>
<?php
include('config.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="style\formstyle.css">
    <script src="https://kit.fontawesome.com/9d4783e555.js" crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        .tableview{
            width:100%;
        }
    </style>
</head>

<body>
    <?php
    require_once('inc/header.php');
    ?>
    <div class="container tableview">
    <div class="card  ">
        <div class="card-header container">
            <div class="row">
                <h3 class="col">Patient informations</h3>
                <a href="index.php" type="button" class="btn btn-secondary col-2 ajouter_btn">Ajouter un patient</a>
            </div>
        </div>
        <div class="card-body container ">
            <div class="row">
                <table class="table table-bordered table-striped " id="table_data" style="background-color: white;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOM</th>
                            <th>Sexe</th>
                            <th>specialites</th>
                            <th>Num telephone</th>
                            <th>deja consulter ce medecin</th>
                            <th>rendez vous</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $sql = "SELECT patient.patientID, patient.nom as patientnom, patient.sexe, patient.num_tel, patient.specialite_boolean, patient.rdv, specialite.nom , GROUP_CONCAT(specialite.nom SEPARATOR '<br>') as specialites
                    FROM patient 
                    LEFT JOIN consultation ON patient.patientID = consultation.patientID 
                    LEFT JOIN specialite ON consultation.specialiteID = specialite.specialiteID
                    GROUP BY patient.patientID, patient.nom, patient.sexe, patient.rdv";
                        $statement = $connection->prepare($sql);
                        $statement->execute();
                        $statement->setFetchMode(PDO::FETCH_ASSOC);
                        $resault = $statement->fetchall();
                        if ($resault) {
                            foreach ($resault as $row) {
                        ?>
                                <tr>
                                    <td><?= $row['patientID'] ?></td>
                                    <td><?= $row['patientnom'] ?></td>
                                    <td><?= $row['sexe'] ?></td>
                                    <td><?= $row['specialites'] ?></td>
                                    <td><?= $row['num_tel'] ?></td>
                                    <td><?= $row['specialite_boolean'] ?></td>
                                    <td><?= $row['rdv'] ?></td>
                                    <td>
                                        <a href="patient_update.php?id=<?= $row['patientID']; ?>" class="btn btn-primary">Edit</a>
                                        <a href="bill_pdf.php?id=<?= $row['patientID']; ?>" class="btn btn-primary">Facture</a>
                                        <a href="patient_delete.php?id=<?php echo $row['patientID']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce patient ?')"><i class="fa-solid fa-trash danger fa-2x" style="color: #D21312;"></i></a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5">
                                    Aucun Enregistrement Trouvé
                                </td>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="js/table_page.js"></script>
</body>

</html>
<?php  }?>