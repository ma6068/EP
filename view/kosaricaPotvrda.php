<?php

    include 'konekcija.php';
    session_start();
    
    $broj = $_POST['broj'];
    $id_kosarica = $_GET['id_kosarica'];
    $_SESSION['id_kosarica'] = $id_kosarica;
    // menuvame status od oddano vo neobdelano
    $query = "UPDATE kosarica SET status='neobdelano', kolicina='$broj' WHERE id_kosarica='$id_kosarica'";
    $rezultat = mysqli_query($conn, $query);
    
    header('Location: ' . "./strankaKosarica.php");
    exit();
?>
