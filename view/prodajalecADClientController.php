<?php

    session_start();
    include 'konekcija.php';
    
    $id_uporabnik = $_GET["id_uporabnik"];
    
    // vrati go segasniot status
    $query = "SELECT * FROM uporabnik WHERE id_uporabnik='$id_uporabnik'";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_fetch_assoc($rezultat);
    
    $status = $podatoci['status'];
   
    // smeni go statusot
    if ($status == 'aktiven') {
        $query = "UPDATE uporabnik SET status='deaktiviran' WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
    }
    else {
        $query = "UPDATE uporabnik SET status='aktiven' WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
    }
    $_SESSION['napaka'] = "";
    header('Location: ' . "./prodajalecEditClient.php");
    exit();
?>



