<?php

    include 'konekcija.php';
    session_start();
	
    $ime = mysqli_real_escape_string($conn, $_POST["ime"]);
    $priimek = mysqli_real_escape_string($conn, $_POST["priimek"]);
    $postna_stevilka = mysqli_real_escape_string($conn, $_POST["postna_stevilka"]);
    $mesto = mysqli_real_escape_string($conn, $_POST["mesto"]);
    $ulica = mysqli_real_escape_string($conn, $_POST["ulica"]);
    $hisna_stevilka = mysqli_real_escape_string($conn, $_POST["hisna_stevilka"]);
    $telefon = mysqli_real_escape_string($conn, $_POST["telefon"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $geslo = mysqli_real_escape_string($conn, $_POST["geslo"]);
    $ponoviGeslo = mysqli_real_escape_string($conn, $_POST["ponoviGeslo"]);
    
    
    // pasvordite ne se sovpagat
    if($geslo != $ponoviGeslo) {
	mysqli_stmt_close($sql); 
	mysqli_close($conn);
	$_SESSION["napaka"] = "Passwords don't match";
	header('Location: ' . "./prodajalecAddClient.php");
	exit();
    }
    
    // nekoi polinja se prazni
    if (empty($ime) || empty($priimek) || empty($postna_stevilka) || empty($mesto) 
            || empty($ulica)|| empty($hisna_stevilka) || empty($telefon) || empty($email) || empty($geslo) || empty($ponoviGeslo)) {
        $_SESSION["napaka"] = "Please fill in all fields";
        header('Location: ' . "./prodajalecAddClient.php");
        exit();
    }

    // barame dali postoi toj korisnik
    $query = "SELECT * FROM uporabnik WHERE email='$email'";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
            
    // ako postoi so takov email ne moze pak da se registrira
    if ($brojPodatoci > 0) {
        mysqli_stmt_close($sql); 
        mysqli_close($conn);
	$_SESSION["napaka"] = "User with that email already exists";
	header('Location: ' . "./prodajalecAddClient.php");
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
	header('Location: ' . "./prodajalecAddClient.php");
	exit();
    }
    
    // ako ne postoi go dodavame vo bazata 
    $query = "SELECT id_naslov FROM naslov WHERE postna_stevilka='$postna_stevilka' AND mesto='$mesto' AND ulica='$ulica' AND hisna_stevilka='$hisna_stevilka'";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
	
    // taa adresa prv pat ja gledame i ja dodavame vo bazata
    if($brojPodatoci == 0) {
        $query = "INSERT INTO naslov (postna_stevilka, mesto, ulica, hisna_stevilka)
                      VALUES ('$postna_stevilka', '$mesto', '$ulica', '$hisna_stevilka')";
        $dodadeno = mysqli_query($conn, $query);
        if (!dodadeno) {
            mysqli_stmt_close($sql); 
            mysqli_close($conn);
            $_SESSION["napaka"] = $_SESSION["napaka"] . "Error while adding address";
            header('Location: ' . "./prodajalecAddClient.php");
            exit();
        }   	
    }
    // go zemame id-to na adresata 
    $query = "SELECT id_naslov FROM naslov WHERE postna_stevilka='$postna_stevilka' AND mesto='$mesto' AND ulica='$ulica' AND hisna_stevilka='$hisna_stevilka'";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_fetch_assoc($rezultat);
    $fk_id_naslov = $podatoci['id_naslov'];
    
    
    // skrien pasvord
    $skrienPasvord = password_hash($geslo, PASSWORD_BCRYPT);
        
    // go dodavame uporabnikot
    $query = "INSERT INTO uporabnik (ime, priimek, email, geslo, telefon, status, uloga, fk_id_naslov) VALUES ('$ime', '$priimek', '$email', '$skrienPasvord', '$telefon', 'aktiven', 'stranka', '$fk_id_naslov')";
    $dodadeno = mysqli_query($conn, $query);
    if (dodadeno) {
        $_SESSION["napaka"] = "Successfully added user";
        header('Location: ' . "./prodajalecAddClient.php");
        exit();
    }
    else {
        mysqli_stmt_close($sql); 
        mysqli_close($conn);
        $_SESSION["napaka"] = $_SESSION["napaka"] . "Error while adding user";
        header('Location: ' . "./prodajalecAddClient.php");
        exit();
    }
?>
