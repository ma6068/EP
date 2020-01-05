<?php

    session_start();
    include 'konekcija.php';
    
    $email = $_POST["email"];
    $geslo = $_POST["geslo"];
    $status = $_POST["status"];
    
    // ako ima prazno pole
    if (empty($email) || empty($geslo) || empty(status)) {
        $_SESSION["napaka"] = "Please fill in all fields";
        header('Location: ' . "./prodajalecADClient.php");
        exit();
    }
    
    // vidi dali imas uporabnik so takov email
    $query = "SELECT * FROM uporabnik WHERE email='$email' AND geslo='$geslo' AND uloga='stranka'";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
    $podatoci = mysqli_fetch_assoc($rezultat);
    
    // ako nema, ne moze nisto da se smeni 
    if($brojPodatoci == 0) {
        mysqli_stmt_close($sql); 
        mysqli_close($conn);
        $_SESSION["napaka"] = "Can't find that client";
        header('Location: ' . "./prodajalecADClient.php");
        exit();
    }
    
    // gresno nastaven status
    if ($status != 'aktiven' && $status != 'deaktiviran') {
        $_SESSION["napaka"] = "Status can be only aktiven or deaktiviran";
        header('Location: ' . "./prodajalecADClient.php");
        exit();
    }
    
    // statusot e veke aktiven i probame pak da go stavime aktiven
    if ($status == 'aktiven' && $podatoci['status']=='aktiven') {
        $_SESSION["napaka"] = "Client is already activated";
        header('Location: ' . "./prodajalecADClient.php");
        exit();
    }
    
    // statusot e veke deaktiviran i probame pak da go stavime deaktiviran
    if ($status == 'deaktiviran' && $podatoci['status']=='deaktiviran') {
        $_SESSION["napaka"] = "Client is already deactivated";
        header('Location: ' . "./prodajalecADClient.php");
        exit();
    }
    
    // smeni go statusot 
    $id=$podatoci['id_uporabnik'];
    $query = "UPDATE uporabnik SET status='$status' WHERE id_uporabnik='$id'";
    $rezultat = mysqli_query($conn, $query);
    $_SESSION["napaka"] = "Status successfully changed";
    header('Location: ' . "./prodajalecADClient.php");
    exit();
?>



