<?php 
    
    session_start();
    include 'konekcija.php';
    
    $marka = $_POST["marka"];
    $cena = $_POST["cena"];
    $slika = $_POST["slika"];
    $aktiven = $_POST["aktiven"];
    $opis = $_POST["opis"];
    
    $id_avto = $_SESSION['id_avto'];
    
    // ako ima prazno pole
    if (empty($marka) || empty($cena) || empty($slika) || empty($opis) || empty($aktiven)) {
        $_SESSION["napaka"] = "Please fill in all fields";
        header('Location: ' . "editAvto2.php");
        exit();
    }
    
    
    // ako aktiven gresno nastaveno
    if ($aktiven!=1 && $aktiven!=2) {
        $_SESSION["napaka"] = "Illegal activation value";
        header('Location: ' . "editAvto2.php");
        exit();
    }
    
    
    // editiraj ja kolata 
    $query = "UPDATE avto SET marka='$marka', cena='$cena', slika='$slika', aktiven='$aktiven', opis='$opis' WHERE id_avto='$id_avto'";
    $rezultat = mysqli_query($conn, $query);
    $_SESSION["napaka"] = "Car successfully edited";
    header('Location: ' . "editAvto2.php");
    exit();
    

?>

