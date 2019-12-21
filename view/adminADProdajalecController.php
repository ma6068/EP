<?php

    session_start();
    include 'konekcija.php';
    
    $email = $_POST["email"];
    $geslo = $_POST["geslo"];
    $status = $_POST["status"];
    
    // ako ima prazno pole
    if (empty($email) || empty($geslo) || empty(status)) {
        $_SESSION["napaka"] = "Please fill in all fields";
        header('Location: ' . "./adminADProdajalec.php");
        exit();
    }
    
    // vidi dali imas uporabnik so takov email
    $query = "SELECT * FROM uporabnik WHERE email='$email' AND geslo='$geslo' AND uloga='prodajalec'";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
    $podatoci = mysqli_fetch_assoc($rezultat);
    
    // ako nema, ne moze nisto da se smeni 
    if($brojPodatoci == 0) {
        mysqli_stmt_close($sql); 
        mysqli_close($conn);
        $_SESSION["napaka"] = "Can't find that seller";
        header('Location: ' . "./adminADProdajalec.php");
        exit();
    }
    
    // smeni go statusot 
    $id=$podatoci['id_uporabnik'];
    $query = "UPDATE uporabnik SET status='$status' WHERE id_uporabnik='$id'";
    $rezultat = mysqli_query($conn, $query);
    $_SESSION["napaka"] = "Status successfully changed";
    header('Location: ' . "./adminADProdajalec.php");
    exit();
?>



