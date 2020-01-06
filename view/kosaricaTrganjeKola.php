<?php

    include 'konekcija.php';
    session_start();
    
    $id_avto= mysqli_real_escape_string($conn, $_GET['id_avto']);
    $id_kosarica = $_SESSION['id_kosarica'];
    
    $_SESSION['id_kosarica'] = $id_kosarica;
    $_SESSION['id_avto'] = $id_avto;
    
    // ja briseme kolata (kosaricata moze na uste mesta da ja ima)
    $query = "DELETE FROM kosarica_avto WHERE fk_id_k='$id_kosarica' AND fk_id_a='$id_avto'";
    $rezultat = mysqli_query($conn, $query);
    
    // proveruvame dali uste ja ima kosaricata
    $query = "SELECT * FROM kosarica_avto WHERE fk_id_k=$id_kosarica";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_num_rows($rezultat);
    
    // ako nema poveke koli vo kosaricata ja briseme i kosaricata (vo tabela kosarica)
    if ($podatoci == 0) {
        $query = "DELETE FROM kosarica WHERE id_kosarica='$id_kosarica'";
        $rezultat = mysqli_query($conn, $query);
    }
    
    header('Location: ' . "./strankaKosarica.php");
    exit();
?>
