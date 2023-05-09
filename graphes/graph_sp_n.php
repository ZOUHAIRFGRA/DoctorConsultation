<?php
require('../config.php');
$query4 = "SELECT  COUNT(consultation.patientID) as nbr_pat, consultation.specialiteID,specialite.nom 
FROM consultation  
LEFT JOIN specialite ON consultation.specialiteID = specialite.specialiteID 
GROUP BY specialiteID";
$stm4 = $connecAtion->prepare($query4);
$stm4->execute();
$row4 = $stm4->fetchAll();
$nb1 = $row4[0]['nbr_pat'] ?? 0;
$nb2 = $row4[1]['nbr_pat'] ?? 0;
$nb3 = $row4[2]['nbr_pat'] ?? 0;
$nb4 = $row4[3]['nbr_pat'] ?? 0;
$nb5 = $row4[4]['nbr_pat'] ?? 0;
$nb6 = $row4[5]['nbr_pat'] ?? 0;
$nb7 = $row4[6]['nbr_pat'] ?? 0;
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
                labels: ['ORL', 'Chirurgien-dentiste', 'Médecin généraliste', 'Pédiatre', 'Gynécologue médical et obstétrique', 'Ophtalmologue', 'Dermatologue et vénérologue'],
                datasets: [{
                    label: 'consultations',
                    data: [<?php echo json_encode($nb1); ?>, <?php echo json_encode($nb2); ?>,
                        <?php echo json_encode($nb3); ?>, <?php echo json_encode($nb4); ?>,
                        <?php echo json_encode($nb5); ?>, <?php echo json_encode($nb6); ?>,
                        <?php echo json_encode($nb7); ?>
                    ],
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