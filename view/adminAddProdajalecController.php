<?php

    session_start();
    include 'konekcija.php';
    
    $ime = $_POST["ime"];
    $priimek = $_POST["priimek"];
    $email = $_POST["email"];
    $geslo = $_POST["geslo"];
    
    // ako ima prazno pole
    if (empty($ime) || empty($priimek) || empty($email) || empty($geslo)) {
        $_SESSION["napaka"] = "Please fill in all fields";
        header('Location: ' . "./adminAddProdajalec.php");
        exit();
    }
    
    // vidi dali imas uporabnik so takov email
    $query = "SELECT * FROM uporabnik WHERE email='$email'";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
    $podatoci = mysqli_fetch_assoc($rezultat);
    if($brojPodatoci > 0) {
        mysqli_stmt_close($sql); 
        mysqli_close($conn);
        $_SESSION["napaka"] = "User with that email doesn't exists";
        header('Location: ' . "./adminAddProdajalec.php");
        exit();
    }
    
    // dodaj go prodavacot
    $query="INSERT INTO uporabnik(ime, priimek, email, geslo, status, uloga) VALUES('$ime', '$priimek', '$email', '$geslo', 'aktiven', 'prodajalec')";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
    $podatoci = mysqli_fetch_assoc($rezultat);
    $_SESSION["napaka"] = "Successfully added saller";
    header('Location: ' . "./adminAddProdajalec.php");
    exit();
?>


