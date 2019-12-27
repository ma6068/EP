<?php 
    
    session_start();
    include 'konekcija.php';
    
    $slika = $_POST["slika"];
    
    $id_avto = $_SESSION['id_avto'];
    
    // ako ima prazno pole 
    if (empty($slika)) {
        $_SESSION["napaka"] = "Please fill in all fields";
        header('Location: ' . "./deleteAvtoSlika2.php?id_avto=$id_avto");
        exit();
    }
    
    // gledame dali taa slika veke ja ima 
    $query = "SELECT * FROM avto_slika WHERE slika='$slika' AND fk_id_avto='$id_avto'";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
   
    // slikata ja nema 
    if ($brojPodatoci == 0) {
        $_SESSION["napaka"] = "Can't find that photo";
        header('Location: ' . "./deleteAvtoSlika2.php?id_avto=$id_avto");
        exit();
    }
    
    // ja ima pa ja briseme slikata 
    $query = "DELETE FROM avto_slika WHERE slika='$slika' AND fk_id_avto='$id_avto'";
    $rezultat = mysqli_query($conn, $query);
    $_SESSION["napaka"] = "Car's photo successfully deleted";
    header('Location: ' . "./deleteAvtoSlika2.php?id_avto=$id_avto");
    exit();
    

?>

