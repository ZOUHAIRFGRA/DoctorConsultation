<?php
session_start();
if(!isset($_SESSION['password'])){
    header('location:login.php');
}else{
?>
<?php
require('config.php');
$id = $_GET['id'];
if (isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $sexe = $_POST['sexe'];
    $num_tel = $_POST['num_tel'];
    $consultatoinmed = $_POST['consultatoinmed'];
    $rdv = $_POST['date'] . " " . $_POST['heure'];
    $specialiste = $_POST["specialiste"];

    $sql = "UPDATE patient 
    SET nom = :nom , sexe = :sexe , num_tel = :num_tel,specialite_boolean = :specialite_boolean,rdv = :rdv 
    WHERE patientID = :id ";
    $statement = $connection->prepare($sql);
    $statement->execute([':nom' => $nom, ':sexe' => $sexe, ':num_tel' => $num_tel, ':specialite_boolean' => $consultatoinmed, ':rdv' => $rdv, ':id' => $id]);
    // Delete the existing consultation for the patient
    $sql2 = "DELETE from consultation where patientID=:patientID ";
    $statement2 = $connection->prepare($sql2);
    $statement2->execute([':patientID' => $id]);


    // Insert the consultation table new information 
    foreach ($specialiste as $value) {
        $sql3 = "INSERT INTO consultation (specialiteID, patientID) VALUES (:value, :patientID)";
        $statement3 = $connection->prepare($sql3);
        $statement3->execute([':value' => $value, ':patientID' => $id]);
    }
    if ($statement and $statement2 and $statement3) {

        header('location:view.php?msg=Data updated successfully');
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
    <title>Document</title>
</head>

<body>
    <?php
    require_once('inc/header.php')
    ?>
    <?php
    //this request is for collect the information from table patient and specialite with join to join between the 3 table
    $sql = "SELECT p.*, GROUP_CONCAT(s.nom SEPARATOR ',') as specialites
            FROM patient p
            JOIN consultation c ON p.patientID = c.patientID
            JOIN specialite s ON c.specialiteID = s.specialiteID
            WHERE p.patientID = :id
            LIMIT 1";

    $statement = $connection->prepare($sql);
    $statement->execute([':id' => $id]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $exploded_rdv = explode(" ", $row['rdv']);
    ?>
    <form class=" container  d-flex justify-content-center " method="post">
        <div class="col-6">
            <div class="form-group">
                <label for="nom">Nom complete:</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $row['nom']; ?>" required>
            </div>

            <div class="form-group">
                <label for="sex">Sexe:</label>
                <select class="form-control" id="sexe" name="sexe" required>
                    <option value="">Sélectionnez</option>
                    <option value="homme" <?php echo ($row['sexe'] == 'homme') ? "selected" : ""; ?>>Homme</option>
                    <option value="femme" <?php echo ($row['sexe'] == 'femme') ? "selected" : ""; ?>>Femme</option>
                </select>
            </div>
            <div class="form-group">
                <label for="num_tel">numero de telephone:</label>
                <input type="tel" class="form-control" id="num_tel" name="num_tel" value="<?php echo $row['num_tel']; ?>" required>
            </div>
            <div class="form-group">
                <label>Avez-vous déjà consulter ce médicine?</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="consultatoinmed" id="oui" value="1" <?php echo ($row['specialite_boolean'] == '1') ? "checked" : ""; ?>>
                    <label class="form-check-label" for="oui">
                        Oui
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="consultatoinmed" id="non" value="0" <?php echo ($row['specialite_boolean'] == '0') ? "checked" : ""; ?>>
                    <label class="form-check-label" for="non">
                        Non
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>selectionnez votre specialiste</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="specialiste[]" value="1" <?php echo (str_contains($row['specialites'], 'ORL')) ? "checked" : ""; ?> id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        ORL
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="specialiste[]" value="2" <?php echo (str_contains($row['specialites'], 'Chirurgien-dentiste')) ? "checked" : ""; ?> id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Chirurgien-dentiste
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="specialiste[]" value="3" <?php echo (str_contains($row['specialites'], 'Médecin généraliste')) ? "checked" : ""; ?> id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Médecin généraliste
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="specialiste[]" value="4" <?php echo (str_contains($row['specialites'], 'Pédiatre')) ? "checked" : ""; ?> id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Pédiatre
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="specialiste[]" value="5" <?php echo (str_contains($row['specialites'], 'Gynécologue médical et obstétrique')) ? "checked" : ""; ?> id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Gynécologue médical et obstétrique
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="specialiste[]" value="6" <?php echo (str_contains($row['specialites'], 'Ophtalmologue')) ? "checked" : ""; ?> id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Ophtalmologue
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="specialiste[]" value="7" <?php echo (str_contains($row['specialites'], 'Dermatologue et vénérologue')) ? "checked" : ""; ?> id="flexCheckChecked">
                    <label class="form-check-label" for="flexCheckChecked">
                        Dermatologue et vénérologue
                    </label>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="date">Date du rendez-vous:</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo $exploded_rdv[0]; ?>" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="heure">Heure du rendez-vous:</label>
                        <input type="time" class="form-control" id="heure" name="heure" value="<?php echo $exploded_rdv[1]; ?>" required>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 py-3  text-center col">
                        <button type="submit" class="btn btn-success" name="submit">Update</button>
                    </div>
                    <div class="col-md-6 py-3  text-center col">
                        <a href="view.php" class="btn btn-warning">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

</body>

</html>
<?php  }?>