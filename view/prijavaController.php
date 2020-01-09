<?php
	session_start();
	include 'konekcija.php';
	
        $email = iscisti(mysqli_real_escape_string($conn, $_POST["email"]));
        $geslo = iscisti(mysqli_real_escape_string($conn, $_POST["geslo"]));
        
        // vrni error ako ne se ispolneti site poljinja
        if (empty($email) || empty($geslo)) {
            $_SESSION["napaka"] = "Please fill in all fields";
            header('Location: ' . "./prijava.php");
            exit();
        }
        
        // vidi dali imas stranka so takov email
	$query = "SELECT * FROM uporabnik WHERE email='$email' AND uloga='stranka'";
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
                // tocen pasvord 
                if (password_verify($geslo, $podatoci['geslo'])) {
                    $_SESSION['id_uporabnik'] = $podatoci['id_uporabnik'];
                    $_SESSION['ime'] = $podatoci['ime'];
                    $_SESSION['priimek'] = $podatoci['priimek'];
                    $_SESSION['email'] = $podatoci['email'];
                    $_SESSION['uloga'] = $podatoci['uloga'];
                    header('Location: ' . "./editStranka.php");
                    /*if ($_SESSION['uloga']=='admin') {
                        header('Location: ' . "./index.php");
                    }
                    if ($_SESSION['uloga']=='prodajalec') {
                        header('Location: ' . "./index.php");
                    }
                    if ($_SESSION['uloga']=='stranka') {
                        header('Location: ' . "./editStranka.php");
                    }*/
                    exit();
                }
                // gresen prasvord 
                else {
                    mysqli_stmt_close($sql); 
                    mysqli_close($conn);
                    $_SESSION["napaka"] = "Wrong password !";
                    header('Location: ' . "./prijava.php");
                    exit();
                }
            }
        } 
?>

