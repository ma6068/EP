<?php 
    
    session_start();
    include 'konekcija.php';
    
    $id_kosarica = $_SESSION["id_kosarica"];
    $id_avto = $_SESSION['id_avto'];
    
    $kolicina = mysqli_real_escape_string($conn, $_POST['kolicina']);
    
    // ako ima prazno pole 
    if (empty($kolicina)) {
        $_SESSION["napaka"] = "Please fill in field";
        header('Location: ' . "./avtoKolicina.php?id_avto=$id_avto");
        exit();
    }
    
    // ja editirame kolicinata 
    $query = "UPDATE kosarica_avto SET kolicina='$kolicina' WHERE fk_id_k='$id_kosarica' AND fk_id_a='$id_avto'";
    $rezultat = mysqli_query($conn, $query);
    $_SESSION["napaka"] = "Car's amount successfully edited";
    header('Location: ' . "./avtoKolicina.php?id_avto=$id_avto");
    exit();
    

?>



