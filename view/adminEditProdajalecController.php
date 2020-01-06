<?php

    session_start();
    include 'konekcija.php';
    
    $ime = mysqli_real_escape_string($conn, $_POST["ime"]);
    $priimek = mysqli_real_escape_string($conn, $_POST["priimek"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $geslo = mysqli_real_escape_string($conn, $_POST["geslo"]);
    
    $id_uporabnik = $_SESSION['id_u'];
    
    // ako site polinja se prazni
    if (empty($ime) && empty($priimek) && empty($email) && empty($geslo)) {
        $_SESSION["napaka"] = "Nothing to change";
        header('Location: ' . "./adminEditProdajalec2.php?id_uporabnik=$id_uporabnik");
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
        header('Location: ' . "./adminEditProdajalec2.php?id_uporabnik=$id_uporabnik");
        exit();
    }
        
    // ime
    if (!empty($ime)) {
        $query = "UPDATE uporabnik SET ime='$ime' WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION["napaka"] = "Changes successfully saved";
    }
    
    // priimek
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
            header('Location: ' . "./adminEditProdajalec2.php?id_uporabnik=$id_uporabnik");
            exit();
        }
        $skrienPasvord = password_hash($geslo, PASSWORD_BCRYPT);
        $query = "UPDATE uporabnik SET geslo='$skrienPasvord' WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION["napaka"] = "Changes successfully saved";
    }
    
    header('Location: ' . "./adminEditProdajalec2.php?id_uporabnik=$id_uporabnik");
    exit();
?>

