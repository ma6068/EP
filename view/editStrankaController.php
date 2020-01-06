<?php

    session_start();
    include 'konekcija.php';
    
    $id_uporabnik = $_SESSION['id_uporabnik'];
    
    $ime = mysqli_real_escape_string($conn, $_POST["ime"]);
    $priimek = mysqli_real_escape_string($conn, $_POST["priimek"]);
    $postna_stevilka = mysqli_real_escape_string($conn, $_POST["postna_stevilka"]);
    $mesto = mysqli_real_escape_string($conn, $_POST["mesto"]);
    $ulica = mysqli_real_escape_string($conn, $_POST["ulica"]);
    $hisna_stevilka = mysqli_real_escape_string($conn, $_POST["hisna_stevilka"]);
    $telefon = mysqli_real_escape_string($conn, $_POST["telefon"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $geslo = mysqli_real_escape_string($conn, $_POST["geslo"]);
    
    
    // site polinja se prazni
    if (empty($ime) && empty($priimek) && empty($postna_stevilka) && empty($mesto) 
            && empty($ulica) && empty($hisna_stevilka) && empty($telefon) && empty($email) && empty($geslo) && empty($ponoviGeslo)) {
        $_SESSION["napaka"] = "Nothing to change";
        header('Location: ' . "./editStranka.php");
        exit();
    }
    
    
    // imeto
    if (!empty($ime)) {
        $query = "UPDATE uporabnik SET ime='$ime' WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION["napaka"] = "Changes successfully saved";
    }
    // prezime
    if (!empty($priimek)) {
        $query = "UPDATE uporabnik SET priimek='$priimek' WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION["napaka"] = "Changes successfully saved";
    }
    // email
    if (!empty($email)) {
        $query = "UPDATE uporabnik SET email='$email' WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION["napaka"] = "Changes successfully saved";
    }
    // geslo
    if (!empty($geslo)) {
        // validacija pasvord 
        $uppercase = preg_match('@[A-Z]@', $geslo);
        $lowercase = preg_match('@[a-z]@', $geslo);
        $number = preg_match('@[0-9]@', $geslo);
        if(!$uppercase || !$lowercase || !$number || strlen($geslo) < 6) {
            mysqli_stmt_close($sql); 
            mysqli_close($conn);
            $_SESSION["napaka"] = "The password must have a uppercase, lowercase letter, number and length of at least 6 characters";
            header('Location: ' . "./editStranka.php");
            exit();
        }
        $skrienPasvord = password_hash($geslo, PASSWORD_BCRYPT);
        $query = "UPDATE uporabnik SET geslo='$skrienPasvord' WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION["napaka"] = "Changes successfully saved";
    }
    // telefon
    if (!empty($telefon)) {
        $query = "UPDATE uporabnik SET telefon='$telefon' WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION["napaka"] = "Changes successfully saved";
    }
    
    
    // postna_stevilka
    if (!empty($postna_stevilka)) {
        // go zemame id-to na adresata na uporabnikot
        $query = "SELECT fk_id_naslov FROM uporabnik WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $podatoci = mysqli_fetch_assoc($rezultat);
        $fk_id_naslov = $podatoci['fk_id_naslov'];
        
        // gi zemame podatocite na starata adresa na uporabnikot
        $queryStaraAdresa = "SELECT * FROM naslov WHERE id_naslov='$fk_id_naslov'";
        $rezultatStaraAdresa = mysqli_query($conn, $queryStaraAdresa);
        $podatociStaraAdresa = mysqli_fetch_assoc($rezultatStaraAdresa);
        $m = $podatociStaraAdresa['mesto'];
        $u = $podatociStaraAdresa['ulica'];
        $hs = $podatociStaraAdresa['hisna_stevilka'];
        
        // proveruvame kolku luge ja koristat starata adresa 
        $queryPostoiStaraAdresa = "SELECT * FROM uporabnik WHERE fk_id_naslov='$fk_id_naslov'";
        $rezultatPostoiStaraAdresa = mysqli_query($conn, $queryPostoiStaraAdresa);
        $brojPodatociStaraAdresa = mysqli_num_rows($rezultatPostoiStaraAdresa);
        
        // proveruvame dali novata adresa veke postoi
        $queryPostoiNovaAdresa = "SELECT * FROM naslov WHERE postna_stevilka='$postna_stevilka' AND mesto='$m' AND ulica='$u' AND hisna_stevilka='$hs'";
        $rezultatPostoiNovaAdresa = mysqli_query($conn, $queryPostoiNovaAdresa);
        $podatociNovaAdresa = mysqli_fetch_assoc($rezultatPostoiNovaAdresa);
        $brojPodatociNovaAdresa = mysqli_num_rows($rezultatPostoiNovaAdresa);
        
        // zapomni id na starata adresa
        $starId = $fk_id_naslov;
        
        // novata adresa veke postoi
        if ($brojPodatociNovaAdresa > 0) {   
            // go zemame id-to na novata adresa
            $fk_id_naslov = $podatociNovaAdresa['id_naslov'];
        }
        // novata adresa ne postoi
        else {
            // ja dodavame novata adresa 
            $query = "INSERT INTO naslov(postna_stevilka, mesto, ulica, hisna_stevilka) VALUES('$postna_stevilka', '$m', '$u', '$hs')";
            $rezultat = mysqli_query($conn, $query);
            
            // go zemame id-to od novata adresa
            $query = "SELECT * FROM naslov WHERE postna_stevilka='$postna_stevilka' AND mesto='$m' AND ulica='$u' AND hisna_stevilka='$hs'";
            $rezultat = mysqli_query($conn, $query);
            $podatoci = mysqli_fetch_assoc($rezultat);
            $brojPodatoci = mysqli_num_rows($rezultat);
            $fk_id_naslov = $podatoci['id_naslov'];
        }
                        
        // menuvame fk_id_naslov vo uporabnik
        $query = "UPDATE uporabnik SET fk_id_naslov='$fk_id_naslov' WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        // ako starata adresa nikoj ne ja koristi ja briseme
        if ($brojPodatociStaraAdresa == 1) {
            $query = "DELETE FROM naslov WHERE id_naslov='$starId'";
            $rezultat = mysqli_query($conn, $query);
        }
        $_SESSION["napaka"] = "Changes successfully saved";
    }
    
        
    // mesto 
    if (!empty($mesto)) {
        // go zemame id-to na adresata na uporabnikot
        $query = "SELECT fk_id_naslov FROM uporabnik WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $podatoci = mysqli_fetch_assoc($rezultat);
        $fk_id_naslov = $podatoci['fk_id_naslov'];
        
        // gi zemame podatocite na starata adresa na uporabnikot
        $queryStaraAdresa = "SELECT * FROM naslov WHERE id_naslov='$fk_id_naslov'";
        $rezultatStaraAdresa = mysqli_query($conn, $queryStaraAdresa);
        $podatociStaraAdresa = mysqli_fetch_assoc($rezultatStaraAdresa);
        $ps = $podatociStaraAdresa['postna_stevilka'];
        $u = $podatociStaraAdresa['ulica'];
        $hs = $podatociStaraAdresa['hisna_stevilka'];
        
        // proveruvame kolku luge ja koristat starata adresa 
        $queryPostoiStaraAdresa = "SELECT * FROM uporabnik WHERE fk_id_naslov='$fk_id_naslov'";
        $rezultatPostoiStaraAdresa = mysqli_query($conn, $queryPostoiStaraAdresa);
        $brojPodatociStaraAdresa = mysqli_num_rows($rezultatPostoiStaraAdresa);
        
        // proveruvame dali novata adresa veke postoi
        $queryPostoiNovaAdresa = "SELECT * FROM naslov WHERE postna_stevilka='$ps' AND mesto='$mesto' AND ulica='$u' AND hisna_stevilka='$hs'";
        $rezultatPostoiNovaAdresa = mysqli_query($conn, $queryPostoiNovaAdresa);
        $podatociNovaAdresa = mysqli_fetch_assoc($rezultatPostoiNovaAdresa);
        $brojPodatociNovaAdresa = mysqli_num_rows($rezultatPostoiNovaAdresa);
        
        // zapomni id na starata adresa
        $starId = $fk_id_naslov;
        
        // novata adresa veke postoi
        if ($brojPodatociNovaAdresa > 0) {   
            // go zemame id-to na novata adresa
            $fk_id_naslov = $podatociNovaAdresa['id_naslov'];
        }
        // novata adresa ne postoi
        else {
            // ja dodavame novata adresa 
            $query = "INSERT INTO naslov(postna_stevilka, mesto, ulica, hisna_stevilka) VALUES('$ps', '$mesto', '$u', '$hs')";
            $rezultat = mysqli_query($conn, $query);
            
            // go zemame id-to od novata adresa
            $query = "SELECT * FROM naslov WHERE postna_stevilka='$ps' AND mesto='$mesto' AND ulica='$u' AND hisna_stevilka='$hs'";
            $rezultat = mysqli_query($conn, $query);
            $podatoci = mysqli_fetch_assoc($rezultat);
            $brojPodatoci = mysqli_num_rows($rezultat);
            $fk_id_naslov = $podatoci['id_naslov'];
        }
                        
        // menuvame fk_id_naslov vo uporabnik
        $query = "UPDATE uporabnik SET fk_id_naslov='$fk_id_naslov' WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        // ako starata adresa nikoj ne ja koristi ja briseme
        if ($brojPodatociStaraAdresa == 1) {
            $query = "DELETE FROM naslov WHERE id_naslov='$starId'";
            $rezultat = mysqli_query($conn, $query);
        }
        $_SESSION["napaka"] = "Changes successfully saved";
    }
    
    
    // ulica
    if (!empty($ulica)) {
        // go zemame id-to na adresata na uporabnikot
        $query = "SELECT fk_id_naslov FROM uporabnik WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $podatoci = mysqli_fetch_assoc($rezultat);
        $fk_id_naslov = $podatoci['fk_id_naslov'];
        
        // gi zemame podatocite na starata adresa na uporabnikot
        $queryStaraAdresa = "SELECT * FROM naslov WHERE id_naslov='$fk_id_naslov'";
        $rezultatStaraAdresa = mysqli_query($conn, $queryStaraAdresa);
        $podatociStaraAdresa = mysqli_fetch_assoc($rezultatStaraAdresa);
        $m = $podatociStaraAdresa['mesto'];
        $ps = $podatociStaraAdresa['postna_stevilka'];
        $hs = $podatociStaraAdresa['hisna_stevilka'];
        
        // proveruvame kolku luge ja koristat starata adresa 
        $queryPostoiStaraAdresa = "SELECT * FROM uporabnik WHERE fk_id_naslov='$fk_id_naslov'";
        $rezultatPostoiStaraAdresa = mysqli_query($conn, $queryPostoiStaraAdresa);
        $brojPodatociStaraAdresa = mysqli_num_rows($rezultatPostoiStaraAdresa);
        
        // proveruvame dali novata adresa veke postoi
        $queryPostoiNovaAdresa = "SELECT * FROM naslov WHERE postna_stevilka='$ps' AND mesto='$m' AND ulica='$ulica' AND hisna_stevilka='$hs'";
        $rezultatPostoiNovaAdresa = mysqli_query($conn, $queryPostoiNovaAdresa);
        $podatociNovaAdresa = mysqli_fetch_assoc($rezultatPostoiNovaAdresa);
        $brojPodatociNovaAdresa = mysqli_num_rows($rezultatPostoiNovaAdresa);
        
        // zapomni id na starata adresa
        $starId = $fk_id_naslov;
        
        // novata adresa veke postoi
        if ($brojPodatociNovaAdresa > 0) {   
            // go zemame id-to na novata adresa
            $fk_id_naslov = $podatociNovaAdresa['id_naslov'];
        }
        // novata adresa ne postoi
        else {
            // ja dodavame novata adresa 
            $query = "INSERT INTO naslov(postna_stevilka, mesto, ulica, hisna_stevilka) VALUES('$ps', '$m', '$ulica', '$hs')";
            $rezultat = mysqli_query($conn, $query);
            
            // go zemame id-to od novata adresa
            $query = "SELECT * FROM naslov WHERE postna_stevilka='$ps' AND mesto='$m' AND ulica='$ulica' AND hisna_stevilka='$hs'";
            $rezultat = mysqli_query($conn, $query);
            $podatoci = mysqli_fetch_assoc($rezultat);
            $brojPodatoci = mysqli_num_rows($rezultat);
            $fk_id_naslov = $podatoci['id_naslov'];
        }
                        
        // menuvame fk_id_naslov vo uporabnik
        $query = "UPDATE uporabnik SET fk_id_naslov='$fk_id_naslov' WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        // ako starata adresa nikoj ne ja koristi ja briseme
        if ($brojPodatociStaraAdresa == 1) {
            $query = "DELETE FROM naslov WHERE id_naslov='$starId'";
            $rezultat = mysqli_query($conn, $query);
        }
        $_SESSION["napaka"] = "Changes successfully saved";
    }
    
    
    // hisna stevilka
    if (!empty($hisna_stevilka)) {
        // go zemame id-to na adresata na uporabnikot
        $query = "SELECT fk_id_naslov FROM uporabnik WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $podatoci = mysqli_fetch_assoc($rezultat);
        $fk_id_naslov = $podatoci['fk_id_naslov'];
        
        // gi zemame podatocite na starata adresa na uporabnikot
        $queryStaraAdresa = "SELECT * FROM naslov WHERE id_naslov='$fk_id_naslov'";
        $rezultatStaraAdresa = mysqli_query($conn, $queryStaraAdresa);
        $podatociStaraAdresa = mysqli_fetch_assoc($rezultatStaraAdresa);
        $m = $podatociStaraAdresa['mesto'];
        $u = $podatociStaraAdresa['ulica'];
        $ps = $podatociStaraAdresa['postna_stevilka'];
        
        // proveruvame kolku luge ja koristat starata adresa 
        $queryPostoiStaraAdresa = "SELECT * FROM uporabnik WHERE fk_id_naslov='$fk_id_naslov'";
        $rezultatPostoiStaraAdresa = mysqli_query($conn, $queryPostoiStaraAdresa);
        $brojPodatociStaraAdresa = mysqli_num_rows($rezultatPostoiStaraAdresa);
        
        // proveruvame dali novata adresa veke postoi
        $queryPostoiNovaAdresa = "SELECT * FROM naslov WHERE postna_stevilka='$ps' AND mesto='$m' AND ulica='$u' AND hisna_stevilka='$hisna_stevilka'";
        $rezultatPostoiNovaAdresa = mysqli_query($conn, $queryPostoiNovaAdresa);
        $podatociNovaAdresa = mysqli_fetch_assoc($rezultatPostoiNovaAdresa);
        $brojPodatociNovaAdresa = mysqli_num_rows($rezultatPostoiNovaAdresa);
        
        // zapomni id na starata adresa
        $starId = $fk_id_naslov;
        
        // novata adresa veke postoi
        if ($brojPodatociNovaAdresa > 0) {   
            // go zemame id-to na novata adresa
            $fk_id_naslov = $podatociNovaAdresa['id_naslov'];
        }
        // novata adresa ne postoi
        else {
            // ja dodavame novata adresa 
            $query = "INSERT INTO naslov(postna_stevilka, mesto, ulica, hisna_stevilka) VALUES('$ps', '$m', '$u', '$hisna_stevilka')";
            $rezultat = mysqli_query($conn, $query);
            
            // go zemame id-to od novata adresa
            $query = "SELECT * FROM naslov WHERE postna_stevilka='$ps' AND mesto='$m' AND ulica='$u' AND hisna_stevilka='$hisna_stevilka'";
            $rezultat = mysqli_query($conn, $query);
            $podatoci = mysqli_fetch_assoc($rezultat);
            $brojPodatoci = mysqli_num_rows($rezultat);
            $fk_id_naslov = $podatoci['id_naslov'];
        }
                        
        // menuvame fk_id_naslov vo uporabnik
        $query = "UPDATE uporabnik SET fk_id_naslov='$fk_id_naslov' WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        // ako starata adresa nikoj ne ja koristi ja briseme
        if ($brojPodatociStaraAdresa == 1) {
            $query = "DELETE FROM naslov WHERE id_naslov='$starId'";
            $rezultat = mysqli_query($conn, $query);
        }
        $_SESSION["napaka"] = "Changes successfully saved";
    }
    
    header('Location: ' . "./editStranka.php");
    exit();
?>
