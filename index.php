<?php
session_start();
if (isset($_SESSION['password'])) {

?>
    <?php
    require('config.php');
    if (isset($_POST['submit'])) {
        $nom = $_POST['nom'];
        $sexe = $_POST['sexe'];
        $num_tel = $_POST['num_tel'];
        $consultatoinmed = $_POST['consultatoinmed'];
        $rdv = $_POST['date'] . " " . $_POST['heure'];
        $specialiste = $_POST["specialiste"];
        $sql = "INSERT INTO patient (nom, sexe, num_tel, specialite_boolean, rdv)
    VALUES (:nom, :sexe, :num_tel, :specialite_boolean, :rdv)";
        $stmt = $connection->prepare($sql);
        $stmt->execute(['nom' => $nom, 'sexe' => $sexe, 'num_tel' => $num_tel, 'specialite_boolean' => $consultatoinmed, 'rdv' => $rdv]);
        $patientID = $connection->lastInsertId();
        foreach ($specialiste as $value) {
            $sql = "INSERT INTO consultation (specialiteID,patientID) VALUES (:value, :patientID)";
            $statement = $connection->prepare($sql);
            $statement->execute([':value' => $value, 'patientID' => $patientID]);
        };
        if ($statement) {
            echo "<script>alert('Succesfully registred')</script>";
            header('Location:view.php');
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <style>
            body {
                background: linear-gradient(to right, #8e2de2, #4a00e0);
                color: #fff;
                font-family: Arial, sans-serif;
            }

            .container {
                margin-top: 50px;
            }

            .cardcolor {
                background-color: rgba(255, 255, 255, 0.2);
                border: none;
            }

            .card-header {
                background-color: rgba(0, 0, 0, 0.4);
                border-bottom: none;
                font-weight: bold;
                padding: 10px;
                text-align: center;
            }

            label {
                font-weight: bold;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-control {
                border-radius: 0;
                background-color: rgba(255, 255, 255, 0.8);
                color: #000;
            }

            .form-check-label {
                font-weight: normal;
            }

            #submit {
                width: 100%;
            }
        </style>
        <title>Document</title>
    </head>

    <body>
        <?php
        require_once('inc/header.php')
        ?>
        <div class="container col-6">
            <div class="card cardcolor">
                <div class="card-header">
                    Registration Form

                </div>
                <form class=" container  d-flex justify-content-center card-body " method="post">
                    <div class="col-11">
                        <div class="form-group">
                            <label for="nom">Full Name:</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>

                        <div class="form-group">
                            <label for="sex">Sexe:</label>
                            <select class="form-control" id="sexe" name="sexe" required>
                                <option value="">Sélectionnez</option>
                                <option value="homme">Homme</option>
                                <option value="femme">Femme</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="num_tel">numero de telephone:</label>
                            <input type="tel" class="form-control" id="num_tel" name="num_tel" required>
                        </div>
                        <div class="form-group">
                            <label>Avez-vous déjà consulter ce Medecin?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="consultatoinmed" id="oui" value="1">
                                <label class="form-check-label" for="oui">
                                    Oui
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="consultatoinmed" id="non" value="0">
                                <label class="form-check-label" for="non">
                                    Non
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>selectionnez votre specialiste</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="specialiste[]" value="1" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    ORL
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="specialiste[]" value="2" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Chirurgien-dentiste
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="specialiste[]" value="3" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Médecin généraliste
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="specialiste[]" value="4" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Pédiatre
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="specialiste[]" value="5" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Gynécologue médical et obstétrique
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="specialiste[]" value="6" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Ophtalmologue
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="specialiste[]" value="7" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    Dermatologue et vénérologue
                                </label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="date">Date du rendez-vous:</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="heure">Heure du rendez-vous:</label>
                                    <input type="time" class="form-control" id="heure" name="heure" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <input required type="submit" name="submit" id="submit" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </body>

    </html>
<?php

} else {
    header('location:login.php');
} ?>