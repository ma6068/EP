<?php

    session_start();
    include 'konekcija.php';
    
    $ime = mysqli_real_escape_string($conn, $_POST["ime"]);
    $novoIme = mysqli_real_escape_string($conn, $_POST["novoIme"]);
    $priimek = mysqli_real_escape_string($conn, $_POST["priimek"]);
    $novPriimek = mysqli_real_escape_string($conn, $_POST["novPriimek"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $novEmail = mysqli_real_escape_string($conn, $_POST["novEmail"]);
    $geslo = mysqli_real_escape_string($conn, $_POST["geslo"]);
    $novoGeslo = mysqli_real_escape_string($conn, $_POST["novoGeslo"]);
    
    // ako se site prazni
    if (empty($ime) && empty($novoIme) && empty($priimek) && empty($novPriimek) 
            && empty($email) && empty($novEmail) && empty($geslo) && empty($novoGeslo)) {
        $_SESSION["napaka"] = "Nothing to change";
        header('Location: ' . "./editProdajalec.php");
        exit();
    }
    
    // ako ednoto od polinjata e prazno a drugoto ne znaci deka ima gresno ispolneto
    if (empty($ime) && !empty($novoIme) || !empty($ime) && empty($novoIme)) {
        $_SESSION["napaka"] = "Check current or new name";
        header('Location: ' . "./editProdajalec.php");
        exit();
    }
    if (empty($priimek) && !empty($novPriimek) || !empty($priimek) && empty($novPriimek)) {
        $_SESSION["napaka"] = "Check current or new surname";
        header('Location: ' . "./editProdajalec.php");
        exit();
    }
    if (empty($email) && !empty($novEmail) || !empty($email) && empty($novEmail)) {
        $_SESSION["napaka"] = "Check current or new email";
        header('Location: ' . "./editProdajalec.php");
        exit();
    }
    if (empty($geslo) && !empty($novoGeslo) || !empty($geslo) && empty($novoGeslo)) {
        $_SESSION["napaka"] = "Check current or new password";
        header('Location: ' . "./editProdajalec.php");
        exit();
    }
    
    // proveri koi se okej popolneti i napravi promeni 
    // ime 
    if (!empty($ime) && !empty($novoIme)) {
        // proveri dali e toa stvarno negovoto ime
        $sega = $_SESSION['id_uporabnik'];
        $query = "SELECT ime FROM uporabnik WHERE id_uporabnik='$sega'";
        $rezultat = mysqli_query($conn, $query);
        $brojPodatoci = mysqli_num_rows($rezultat);
        $podatoci = mysqli_fetch_assoc($rezultat);
        if ($podatoci['ime'] != $ime) {
            $_SESSION["napaka"] = "Wrong current name";
            header('Location: ' . "./editProdajalec.php");
            exit();
        }
        else {
            $query = "UPDATE uporabnik SET ime='$novoIme' WHERE id_uporabnik='$sega'";
            $rezultat = mysqli_query($conn, $query);
            $_SESSION["napaka"] = "Changes successfully saved";
            header('Location: ' . "./editProdajalec.php");
            //exit();
        }
    }
    // priimek
    if (!empty($priimek) && !empty($novPriimek)) {
        // proveri dali e toa stvarno negovoto prezime
        $sega = $_SESSION['id_uporabnik'];
        $query = "SELECT priimek FROM uporabnik WHERE id_uporabnik='$sega'";
        $rezultat = mysqli_query($conn, $query);
        $brojPodatoci = mysqli_num_rows($rezultat);
        $podatoci = mysqli_fetch_assoc($rezultat);
        if ($podatoci['priimek'] != $priimek) {
            $_SESSION["napaka"] = "Wrong current surname";
            header('Location: ' . "./editProdajalec.php");
            exit();
        }
        else {
            $query = "UPDATE uporabnik SET priimek='$novPriimek' WHERE id_uporabnik='$sega'";
            $rezultat = mysqli_query($conn, $query);
            $_SESSION["napaka"] = "Changes successfully saved";
            header('Location: ' . "./editProdajalec.php");
            //exit();
        }
    }
    // email
    if (!empty($email) && !empty($novEmail)) {
        // proveri dali e toa stvarno negovoto prezime
        $sega = $_SESSION['id_uporabnik'];
        $query = "SELECT email FROM uporabnik WHERE id_uporabnik='$sega'";
        $rezultat = mysqli_query($conn, $query);
        $brojPodatoci = mysqli_num_rows($rezultat);
        $podatoci = mysqli_fetch_assoc($rezultat);
        if ($podatoci['email'] != $email) {
            $_SESSION["napaka"] = "Wrong current email";
            header('Location: ' . "./editProdajalec.php");
            exit();
        }
        else {
            $query = "UPDATE uporabnik SET email='$novEmail' WHERE id_uporabnik='$sega'";
            $rezultat = mysqli_query($conn, $query);
            $_SESSION["napaka"] = "Changes successfully saved";
            header('Location: ' . "./editProdajalec.php");
            //exit();
        }
    }
    // pasvord
    if (!empty($geslo) && !empty($novoGeslo)) {
        // proveri dali e toa stvarno negoviot pasvord
        $sega = $_SESSION['id_uporabnik'];
        $query = "SELECT geslo FROM uporabnik WHERE id_uporabnik='$sega'";
        $rezultat = mysqli_query($conn, $query);
        $brojPodatoci = mysqli_num_rows($rezultat);
        $podatoci = mysqli_fetch_assoc($rezultat);
        // tocen pasvord 
        if (password_verify($geslo, $podatoci['geslo'])) {
            // validacija pasvord 
            $uppercase = preg_match('@[A-Z]@', $novoGeslo);
            $lowercase = preg_match('@[a-z]@', $novoGeslo);
            $number = preg_match('@[0-9]@', $novoGeslo);
            if(!$uppercase || !$lowercase || !$number || strlen($novoGeslo) < 6) {
                mysqli_stmt_close($sql); 
                mysqli_close($conn);
                $_SESSION["napaka"] = "The password must have a uppercase, lowercase letter, number and length of at least 6 characters";
                header('Location: ' . "./editProdajalec.php");
                exit();
            }
            $skrienPasvord = password_hash($novoGeslo, PASSWORD_BCRYPT);
            $query = "UPDATE uporabnik SET geslo='$skrienPasvord' WHERE id_uporabnik='$sega'";
            $rezultat = mysqli_query($conn, $query);
            $_SESSION["napaka"] = "Changes successfully saved";
            header('Location: ' . "./editProdajalec.php");
        }
        // gresen pasvord 
        else {
            $_SESSION["napaka"] = "Wrong current password";
            header('Location: ' . "./editProdajalec.php");
            exit();
        }
    }
    
?>