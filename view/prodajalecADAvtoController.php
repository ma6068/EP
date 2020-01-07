<?php

    session_start();
    include 'konekcija.php';
    
    $id_avto= iscisti(mysqli_real_escape_string($conn, $_GET["id_avto"]));
    
    // vrati go segasniot status
    $query = "SELECT * FROM avto WHERE id_avto='$id_avto'";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_fetch_assoc($rezultat);
    
    $status = $podatoci['aktiven'];
   
    // smeni go statusot
    if ($status == 1) {
        $query = "UPDATE avto SET aktiven='2' WHERE id_avto='$id_avto'";
        $rezultat = mysqli_query($conn, $query);
    }
    else {
        $query = "UPDATE avto SET aktiven='1' WHERE id_avto='$id_avto'";
        $rezultat = mysqli_query($conn, $query);
    }
    $_SESSION['napaka'] = "";
    header('Location: ' . "./editAvto.php");
    exit();
?>



