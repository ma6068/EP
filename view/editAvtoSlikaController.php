<?php 
    
    session_start();
    include 'konekcija.php';
    
    $slika = $_POST["slika"];
    $novaSlika = $_POST["novaSlika"];
    
    $id_avto = $_SESSION['id_avto'];
    
    // ako ima prazno pole 
    if (empty($slika) || empty($novaSlika)) {
        $_SESSION["napaka"] = "Please fill in all fields";
        header('Location: ' . "./editAvtoSlika2.php?id_avto=$id_avto");
        exit();
    }
    
    // ja editirame slikata 
    $query = "UPDATE avto_slika SET slika='$novaSlika' WHERE slika='$slika' AND fk_id_avto='$id_avto'";
    $rezultat = mysqli_query($conn, $query);
    $_SESSION["napaka"] = "Car's photo successfully edited";
    header('Location: ' . "./editAvtoSlika2.php?id_avto=$id_avto");
    exit();
    

?>

