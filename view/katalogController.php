<?php

    include 'konekcija.php';
    session_start();
    
    $id_avto = iscisti(mysqli_real_escape_string($conn, $_GET["id_avto"]));
    $idUporabnik = $_SESSION['id_uporabnik'];
   
    // prvo proveruvame dali toj uporabnik veke ima kosarica
    $query = "SELECT * FROM kosarica WHERE fk_id_uporabnik='$idUporabnik' AND status='oddano'";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
    $podatoci = mysqli_fetch_assoc($rezultat);
    
    // uporabnikot nema kosarica (zatoa praveme kosarica)
    if ($brojPodatoci == 0) {
        $datum = date("Y-m-d h:m:s");
        $query = "INSERT INTO kosarica(datum, status, fk_id_uporabnik) VALUES ('$datum', 'oddano', '$idUporabnik')";
        $rezultat = mysqli_query($conn, $query);
        
        // go zemame id-to od kosaricata so ja napravivme 
        $query = "SELECT * FROM kosarica WHERE fk_id_uporabnik='$idUporabnik' AND status='oddano'";
        $rezultat = mysqli_query($conn, $query);
        $brojPodatoci = mysqli_num_rows($rezultat);
        $podatoci = mysqli_fetch_assoc($rezultat);
    }
   
    $id_kosarica = $podatoci['id_kosarica'];
    
    // proveruvame dali taa kola veke ja ima vo kosaricata
    $query = "SELECT * FROM kosarica_avto WHERE fk_id_k='$id_kosarica' AND fk_id_a='$id_avto'";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
    $podatoci = mysqli_fetch_assoc($rezultat);
    
    // taa kola ja nema vo kosaricata pa ja dodavame
    if ($brojPodatoci == 0) {
        $query = "INSERT INTO kosarica_avto(fk_id_k, fk_id_a, kolicina) VALUES('$id_kosarica', '$id_avto', '1')";
        $rezultat = mysqli_query($conn, $query);
    }
    
    header('Location: ' . "./strankaKosarica.php");
    exit();
    
?>

