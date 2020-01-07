<?php 
    
    session_start();
    include 'konekcija.php';
    
    $slika = iscisti(mysqli_real_escape_string($conn, $_POST["slika"]));
    $novaSlika = iscisti(mysqli_real_escape_string($conn, $_POST["novaSlika"]));
    
    $id_avto = $_SESSION['id_avto'];
    
    // ako ima prazno pole 
    if (empty($slika) || empty($novaSlika)) {
        $_SESSION["napaka"] = "Please fill in all fields";
        header('Location: ' . "./editAvtoSlika.php?id_avto=$id_avto");
        exit();
    }
    
    // gledame dali slikata sto sakame da ja smeneme ja ima 
    $query = "SELECT * FROM avto_slika WHERE slika='$slika' AND fk_id_avto='$id_avto'";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
   
    // slikata ja nema 
    if ($brojPodatoci == 0) {
        $_SESSION["napaka"] = "Can't find that photo";
        header('Location: ' . "./editAvtoSlika.php?id_avto=$id_avto");
        exit();
    }
    
    // gledame dali slikata sto sakame da ja staveme veke ja ima 
    $query = "SELECT * FROM avto_slika WHERE slika='$novaSlika' AND fk_id_avto='$id_avto'";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
   
    // slikata ja nema 
    if ($brojPodatoci > 0) {
        $_SESSION["napaka"] = "That photo already exist";
        header('Location: ' . "./editAvtoSlika.php?id_avto=$id_avto");
        exit();
    }
    
    // ja editirame slikata 
    $query = "UPDATE avto_slika SET slika='$novaSlika' WHERE slika='$slika' AND fk_id_avto='$id_avto'";
    $rezultat = mysqli_query($conn, $query);
    $_SESSION["napaka"] = "Car's photo successfully edited";
    header('Location: ' . "./editAvtoSlika.php?id_avto=$id_avto");
    exit();
    

?>

