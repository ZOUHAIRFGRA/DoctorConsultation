<?php
require('../config.php');
$query5 = "SELECT 
COUNT(CASE WHEN HOUR(rdv) >= 6 AND HOUR(rdv) < 18 THEN 1 END) AS 'Day Consultations',
COUNT(CASE WHEN HOUR(rdv) < 6 OR HOUR(rdv) >= 18 THEN 1 END) AS 'Night Consultations'
FROM 
patient";
$stm5 = $connection->prepare($query5);
$stm5->execute();
$row5 = $stm5->fetchAll();
$nb1 = $row5[0]['Day Consultations'];
$nb2 = $row5[0]['Night Consultations'];
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
                labels: ['Jour', 'Nuit'],
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