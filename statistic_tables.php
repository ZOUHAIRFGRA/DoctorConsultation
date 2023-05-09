<?php
session_start();
if(!isset($_SESSION['password'])){
    header('location:login.php');
}else{
?>
<?php
require('config.php');


$query = "SELECT sexe, count(patientID)AS nombre_par_sexe 
from patient GROUP BY sexe";
$stm = $connection->prepare($query);
$stm->execute();
$row = $stm->fetchAll();

$query2 = "SELECT COUNT(patientID) AS nbr_consultation FROM consultation  ";
$stm2 = $connection->prepare($query2);
$stm2->execute();
$row2 = $stm2->fetch();

$query3 = "SELECT COUNT(patientID) AS nbr_patient FROM patient";
$stm3 = $connection->prepare($query3);
$stm3->execute();
$row3 = $stm3->fetch();

$query4 = "SELECT  COUNT(consultation.patientID) as nbr_pat, consultation.specialiteID,specialite.nom 
FROM consultation  
LEFT JOIN specialite ON consultation.specialiteID = specialite.specialiteID 
GROUP BY specialiteID";
$stm4 = $connection->prepare($query4);
$stm4->execute();
$row4 = $stm4->fetchAll();

$query5 = "SELECT 
            COUNT(CASE WHEN HOUR(rdv) >= 6 AND HOUR(rdv) < 18 THEN 1 END) AS 'Day Consultations',
            COUNT(CASE WHEN HOUR(rdv) < 6 OR HOUR(rdv) >= 18 THEN 1 END) AS 'Night Consultations'
            FROM 
            patient";
$stm5 = $connection->prepare($query5);
$stm5->execute();
$row5 = $stm5->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/formstyle.css">
    <title>Document</title>
</head>

<body>
    <?php
    require_once('inc/header.php')
    ?>
    <div class="card mt-0">
        <div class="card-header">Les Statistiques des Consultations</div>
        <div class="container-fluid card-body ">
            <div class="row">
                <div class="container col-2 ">
                    <table class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <th>specialite</th>
                                <th>Nb de demande</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($row) {
                                foreach ($row4 as $resault2) {
                            ?>
                                    <tr>
                                        <td>
                                            <?= $resault2['nom'] ?>
                                        </td>
                                        <td>
                                            <?= $resault2['nbr_pat'] ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="2">
                                        Aucun Enregistrement Trouvé
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="2">
                                    <div class="d-flex justify-content-center">
                                        <a href="graphes/graph_sp_n.php" class="btn btn-primary">Graph</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="container col-2 ">
                    <table class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <th>Sexe</th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($row) {
                                foreach ($row as $resault) {
                            ?>
                                    <tr>
                                        <td>
                                            <?= $resault['sexe'] ?>
                                        </td>
                                        <td>
                                            <?= $resault['nombre_par_sexe'] ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="2">
                                        Aucun Enregistrement Trouvé
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="2">
                                    <div class="d-flex justify-content-center">
                                        <a href="graphes/graph_h_f.php" class="btn btn-primary">Graph</a>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="container col-2 ">
                    <table class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <th>Horaire</th>
                                <th>Nb des demandes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($row) {
                                foreach ($row5 as $resault3) {
                            ?>
                                    <tr>
                                        <td>
                                            Jour
                                        </td>
                                        <td>
                                            <?= $resault3['Day Consultations'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Nuit
                                        </td>
                                        <td>
                                            <?= $resault3['Night Consultations'] ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="2">
                                        Aucun Enregistrement Trouvé
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="2">
                                    <div class="d-flex justify-content-center">
                                        <a href="graphes/graph_d_n.php" class="btn btn-primary">Graph</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>


                <div class="container col-2">
                    <table class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <th>
                                    Nombre totale des consultation
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php
                                    echo $row2['nbr_consultation']
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="container col-2">
                    <table class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <th>
                                    Nombre totale des patient
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?= $row3['nbr_patient'] ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
<?php  }?>