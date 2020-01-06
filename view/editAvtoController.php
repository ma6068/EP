<?php 
    
    session_start();
    include 'konekcija.php';
    
    $marka = mysqli_real_escape_string($conn, $_POST["marka"]);
    $cena = mysqli_real_escape_string($conn, $_POST["cena"]);
    $opis = mysqli_real_escape_string($conn, $_POST["opis"]);
    
    $id_avto = $_SESSION['id_avto'];
    
    // ako se site prazni
    if (empty($marka) && empty($cena) && empty($opis)) {
        $_SESSION["napaka"] = "Nothing to change";
        header('Location: ' . "./editAvto2.php?id_avto=$id_avto");
        exit();
    }
    
    // marka 
    if (!empty($marka)) {
        $query = "UPDATE avto SET marka='$marka' WHERE id_avto='$id_avto'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION["napaka"] = "Car successfully edited";
    }
    
    // cena 
    if (!empty($cena)) {
        $query = "UPDATE avto SET cena='$cena' WHERE id_avto='$id_avto'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION["napaka"] = "Car successfully edited";
    }
    
    // opis 
    if (!empty($opis)) {
        $query = "UPDATE avto SET opis='$opis' WHERE id_avto='$id_avto'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION["napaka"] = "Car successfully edited";
    }

    header('Location: ' . "./editAvto2.php?id_avto=$id_avto");
    exit();
    

?>

