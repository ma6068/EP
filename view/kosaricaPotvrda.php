<?php

    include 'konekcija.php';
    session_start();
    
    $id_kosarica = $_GET['id_kosarica'];
    $_SESSION['id_kosarica'] = $id_kosarica;
    // menuvame status od oddano vo neobdelano
    $query = "UPDATE kosarica SET status='neobdelano' WHERE id_kosarica='$id_kosarica'";
    $rezultat = mysqli_query($conn, $query);
    
    header('Location: ' . "./strankaKosarica.php");
    exit();
?>
