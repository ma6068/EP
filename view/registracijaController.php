<?php

    include 'konekcija.php';
    session_start();
	
    $ime = $_POST["ime"];
    $priimek = $_POST["priimek"];
    $postna_stevilka = $_POST["postna_stevilka"];
    $mesto = $_POST["mesto"];
    $ulica = $_POST["ulica"];
    $hisna_stevilka = $_POST["hisna_stevilka"];
    $telefon = $_POST["telefon"];
    $email = $_POST["email"];
    $geslo = $_POST["geslo"];
    $ponoviGeslo = $_POST["ponoviGeslo"];
    
    
    // pasvordite ne se sovpagat
    if($geslo != $ponoviGeslo) {
	mysqli_stmt_close($sql); 
	mysqli_close($conn);
	$_SESSION["napaka"] = "Passwords don't match";
	header('Location: ' . "./registracija.php");
	exit();
    }
    
    // nekoi polinja se prazni
    if (empty($ime) || empty($priimek) || empty($postna_stevilka) || empty($mesto) 
            || empty($ulica)|| empty($hisna_stevilka) || empty($telefon) || empty($email) || empty($geslo) || empty($ponoviGeslo)
            || !isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        $_SESSION["napaka"] = "Please fill in all fields";
        header('Location: ' . "./registracija.php");
        exit();
    }
    
    $secret = '6Ld6hcoUAAAAAPY6B_OGBeiIZlFmedIKtWA-65AX';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    
    if (!$responseData->success) {
        $_SESSION["napaka"] = "Verification unsuccessful!";
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
	header('Location: ' . "./registracija.php");
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
            header('Location: ' . "./registracija.php");
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
        $_SESSION["napaka"] = "Registration completed successfully";
        header('Location: ' . "./prijava.php");
        exit();
    }
    else {
        mysqli_stmt_close($sql); 
        mysqli_close($conn);
        $_SESSION["napaka"] = $_SESSION["napaka"] . "Error while adding user";
        header('Location: ' . "./registracija.php");
        exit();
    }
?>
