<?php

require('config.php');
require('fpdf/fpdf.php');

$id = $_GET['id'];

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('images/cmc.jpg',10,6,30);
        $this->Image('images/10130.jpg',180,6,30);
        $this->Image('images/cachet.png',6,260,30);
        $this->Image('images/qrcode.png',160,250,30);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the center of the page
        $this->Cell(0,30,'',0,1,'C');
        // Title
        $this->Cell(0,10,'Facteur',0,1,'C');
        // Line break
        $this->Ln(10);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

$sql = "SELECT p.*, GROUP_CONCAT(s.nom SEPARATOR '<br>') as specialites
            FROM patient p
            JOIN consultation c ON p.patientID = c.patientID
            JOIN specialite s ON c.specialiteID = s.specialiteID
            WHERE p.patientID = :id
            LIMIT 1";

$statement = $connection->prepare($sql);
$statement->execute([':id' => $id]);
$row = $statement->fetch(PDO::FETCH_ASSOC);

// Center the text vertically and horizontally on the page
$pdf->Cell(0, 0, '', 0, 1, 'C');
$pdf->MultiCell(0, 10, "Nom: ".$row['nom']."\nSexe: ".$row['sexe']."\nTel: ".$row['num_tel']."\nLes maladies: ".$row['specialites']."\nPrix totale: ".(substr_count($row['specialites'], "<br>") + 1) * 300 ." DH",0,'C');

$pdf->Output();
?>

