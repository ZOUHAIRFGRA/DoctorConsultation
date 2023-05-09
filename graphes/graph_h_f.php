<?php
require('../config.php');
$query = "SELECT sexe, count(patientID)AS nombre_par_sexe 
from patient GROUP BY sexe";
$stm = $connection->prepare($query);
$stm->execute();
$row = $stm->fetchAll();

$nb1 = $row[1]['nombre_par_sexe']; // number of male patients
$nb2 = $row[0]['nombre_par_sexe'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <title>Document</title>
</head>

<body>
    <?php
    require_once('header.php')
    ?>
    <canvas id="myChart"></canvas>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['homme', 'femme'],
                datasets: [{
                    label: 'consultations',
                    data: [<?php echo json_encode($nb1); ?>, <?php echo json_encode($nb2); ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'

                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 99, 132, 1)'

                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

</body>

</html>