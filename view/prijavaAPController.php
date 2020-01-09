<?php
	session_start();
	include 'konekcija.php';
	
        $geslo = $_SESSION["geslo"];
        $email = $_SESSION["email"];
        
        // vrni error ako nema sertifikat (emailot e prazen)
        if (empty($email)) {
            $_SESSION["napaka"] = "You don't have a certificate";
            header('Location: ' . "./prijavaAP.php");
            exit();
        }
        
        // vrni error ako ne e vnesen pasvordot
        if (empty($geslo)) {
            $_SESSION["napaka"] = "Please fill in the field";
            header('Location: ' . "./prijavaAP.php");
            exit();
        }
        
        // vidi dali imas admin/prodajalec so takov email i pasvord
	$query = "SELECT * FROM uporabnik WHERE email='$email' AND uloga!='stranka'";
        $rezultat = mysqli_query($conn, $query);
        $brojPodatoci = mysqli_num_rows($rezultat);
        $podatoci = mysqli_fetch_assoc($rezultat);
        
        // ne postoi admin/prodajalec so takov email i pasvord
        if($brojPodatoci == 0) {
            mysqli_stmt_close($sql); 
            mysqli_close($conn);
            $_SESSION["napaka"] = "Admin/Prodajalec doesn't exist";
            header('Location: ' . "./prijavaAP.php");
            exit();
        }
        
        // uporabnikot e blokiran
        if ($podatoci['status'] != "aktiven") {
            $_SESSION["napaka"] = "User with that email is deactivated";
            header('Location: ' . "./prijavaAP.php");
            exit();
        }
        
        // postoi takov aktiven uporabnik, proveri mu go pasvordot
        if ($brojPodatoci > 0) {
            if ($podatoci) {
                // tocen pasvord 
                if (password_verify($geslo, $podatoci['geslo'])) {
                    $_SESSION['id_uporabnik'] = $podatoci['id_uporabnik'];
                    $_SESSION['ime'] = $podatoci['ime'];
                    $_SESSION['priimek'] = $podatoci['priimek'];
                    $_SESSION['email'] = $podatoci['email'];
                    $_SESSION['uloga'] = $podatoci['uloga'];
                    if ($_SESSION['uloga']=='admin') {
                        header('Location: ' . "./editAdmin.php");
                    }
                    if ($_SESSION['uloga']=='prodajalec') {
                        header('Location: ' . "./editProdajalec.php");
                    }
                    exit();
                }
                // gresen prasvord 
                else {
                    mysqli_stmt_close($sql); 
                    mysqli_close($conn);
                    $_SESSION["napaka"] = "Wrong password !";
                    header('Location: ' . "./prijavaAP.php");
                    exit();
                }
            }
        } 
?>

