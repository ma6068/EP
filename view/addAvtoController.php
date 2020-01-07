<?php

    session_start();
    include 'konekcija.php';
    
    
    
    $marka = iscisti(mysqli_real_escape_string($conn, $_POST["marka"]));
    $cena = iscisti(mysqli_real_escape_string($conn, $_POST["cena"]));
    $slika = iscisti(mysqli_real_escape_string($conn, $_POST["slika"]));
    $aktiven = iscisti(mysqli_real_escape_string($conn, $_POST["aktiven"]));
    $opis = iscisti(mysqli_real_escape_string($conn, $_POST["opis"]));
    
    // ako ima prazno pole
    if (empty($marka) || empty($opis) || empty($cena) || empty($aktiven)) {
        $_SESSION["napaka"] = "Please fill in all fields";
        header('Location: ' . "./addAvto.php");
        exit();
    }
    
    
    // ako aktiven gresno nastaveno
    if ($aktiven!=1 && $aktiven!=2) {
        $_SESSION["napaka"] = "Illegal activation value";
        header('Location: ' . "./addAvto.php");
        exit();
    }
    
    
    // dodaj ja kolata 
    $query = "INSERT INTO avto (marka, cena, aktiven, opis) VALUES ('$marka', '$cena', '$aktiven', '$opis')";
    $rezultat = mysqli_query($conn, $query);
    $_SESSION["napaka"] = "Car added successfully";
    header('Location: ' . "./addAvto.php");
    exit();
?>