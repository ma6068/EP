<?php

    include 'konekcija.php';
    session_start();
    
    $id_kosarica = $_GET['id_kosarica'];
    
    foreach($_POST['kolicina'] as $k => $kolicina){
        // menuvame status od oddano vo neobdelano i ja menuvame kolicinata
        $query = "UPDATE kosarica SET status='neobdelano', kolicina='$kolicina' WHERE id_kosarica='$id_kosarica'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION['kolicina'] = $kolicina;
    }
    header('Location: ' . "./test.php");
    exit();
?>
