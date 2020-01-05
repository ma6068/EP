<?php 
    
    session_start();
    include 'konekcija.php';
    
    $slika = $_POST["slika"];
    
    $id_avto = $_SESSION['id_avto'];
    
    // ako ima prazno pole 
    if (empty($slika)) {
        $_SESSION["napaka"] = "Please fill in the field";
        header('Location: ' . "./addAvtoSlika2.php?id_avto=$id_avto");
        exit();
    }
    
    // gledame dali taa slika veke ja ima 
    $query = "SELECT * FROM avto_slika WHERE slika='$slika' AND fk_id_avto='$id_avto'";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
   
    // slikata ja ima 
    if ($brojPodatoci > 0) {
        $_SESSION["napaka"] = "Photo already added";
        header('Location: ' . "./addAvtoSlika2.php?id_avto=$id_avto");
        exit();
    }
    
    // ja nemalo pa ja dodavame slikata 
    $query = "INSERT INTO avto_slika(slika, fk_id_avto) VALUES ('$slika', '$id_avto')";
    $rezultat = mysqli_query($conn, $query);
    $_SESSION["napaka"] = "Car's photo successfully added";
    header('Location: ' . "./addAvtoSlika2.php?id_avto=$id_avto");
    exit();
    

?>

