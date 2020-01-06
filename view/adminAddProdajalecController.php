<?php

    session_start();
    include 'konekcija.php';
    
    $ime = mysqli_real_escape_string($conn, $_POST["ime"]);
    $priimek = mysqli_real_escape_string($conn, $_POST["priimek"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $geslo = mysqli_real_escape_string($conn, $_POST["geslo"]);
    
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
    
    // validacija pasvord 
    $uppercase = preg_match('@[A-Z]@', $geslo);
    $lowercase = preg_match('@[a-z]@', $geslo);
    $number = preg_match('@[0-9]@', $geslo);
    if(!$uppercase || !$lowercase || !$number || strlen($geslo) < 6) {
        mysqli_stmt_close($sql); 
        mysqli_close($conn);
	$_SESSION["napaka"] = "The password must have a uppercase, lowercase letter, number and length of at least 6 characters";
	header('Location: ' . "./adminAddProdajalec.php");
	exit();
    }
    
    $skrienPasvord = password_hash($geslo, PASSWORD_BCRYPT);
    
    // dodaj go prodavacot
    $query="INSERT INTO uporabnik(ime, priimek, email, geslo, status, uloga) VALUES('$ime', '$priimek', '$email', '$skrienPasvord', 'aktiven', 'prodajalec')";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
    $podatoci = mysqli_fetch_assoc($rezultat);
    $_SESSION["napaka"] = "Successfully added saller";
    header('Location: ' . "./adminAddProdajalec.php");
    exit();
?>


