<?php
	session_start();
	include 'konekcija.php';
	
	$email = $_POST["email"];
	$geslo = $_POST["geslo"];
        
        // vrni error ako ne se ispolneti site poljinja
        if (empty($email) || empty($geslo)) {
            $_SESSION["napaka"] = "Please fill in all fields";
            header('Location: ' . "./prijava.php");
            exit();
        }
        
        // vidi dali imas uporabnik so takov email
	$query = "SELECT * FROM uporabnik WHERE email='$email'";
        $rezultat = mysqli_query($conn, $query);
        $brojPodatoci = mysqli_num_rows($rezultat);
        $podatoci = mysqli_fetch_assoc($rezultat);
        
        // ne postoi uporabnik so takov email 
        if($brojPodatoci == 0) {
            mysqli_stmt_close($sql); 
            mysqli_close($conn);
            $_SESSION["napaka"] = "User with that email doesn't exists";
            header('Location: ' . "./prijava.php");
            exit();
        }
        
        // uporabnikot e blokiran
        if ($podatoci['status'] != "aktiven") {
            $_SESSION["napaka"] = "User with that email is deactivated";
            header('Location: ' . "./prijava.php");
            exit();
        }
        
        // postoi aktiven uporabnik so takov email, proveri mu go pasvordot
        if ($brojPodatoci > 0) {
            if ($podatoci) {
                //$p = password_verify($geslo, $podatoci['geslo']);
                // if ($p == false) {....
                // gresen pasvord 
                if ($geslo != $podatoci['geslo']) {
                    mysqli_stmt_close($sql); 
                    mysqli_close($conn);
                    $_SESSION["napaka"] = "Wrong password !";
                    header('Location: ' . "./prijava.php");
                    exit();
                } 
                // tocen pasvord 
                else {
                    $_SESSION['id_uporabnik'] = $podatoci['id_uporabnik'];
                    $_SESSION['ime'] = $podatoci['ime'];
                    $_SESSION['priimek'] = $podatoci['priimek'];
                    $_SESSION['email'] = $podatoci['email'];
                    $_SESSION['uloga'] = $podatoci['uloga'];
                    $_SESSION["napaka"] = "Uspesno !";
                    header('Location: ' . "./prijava.php");
                    exit();
                }
            }
        } 
?>

