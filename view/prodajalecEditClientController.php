<?php

    session_start();
    include 'konekcija.php';
    
    $id_uporabnik = $_SESSION['id_uporabnik'];
    
    $ime = $_POST["ime"];
    $priimek = $_POST["priimek"];
    $postna_stevilka = $_POST["postna_stevilka"];
    $mesto = $_POST["mesto"];
    $ulica = $_POST["ulica"];
    $hisna_stevilka = $_POST["hisna_stevilka"];
    $telefon = $_POST["telefon"];
    $email = $_POST["email"];
    $geslo = $_POST["geslo"];
    
    
    // site polinja se prazni
    if (empty($ime) && empty($priimek) && empty($postna_stevilka) && empty($mesto) 
            && empty($ulica) && empty($hisna_stevilka) && empty($telefon) && empty($email) && empty($geslo) && empty($ponoviGeslo)) {
        $_SESSION["napaka"] = "Nothing to change";
        header('Location: ' . "./prodajalecEditClient2.php?id_uporabnik=$id_uporabnik");
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
        header('Location: ' . "./prodajalecEditClient2.php?id_uporabnik=$id_uporabnik");
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
        $query = "UPDATE uporabnik SET geslo='$geslo' WHERE id_uporabnik='$id_uporabnik'";
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
        $query = "SELECT fk_id_naslov FROM uporabnik WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $podatoci = mysqli_fetch_assoc($rezultat);
        $fk_id_naslov = $podatoci['fk_id_naslov'];
        $query = "UPDATE naslov SET postna_stevilka='$postna_stevilka' WHERE id_naslov='$fk_id_naslov'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION["napaka"] = "Changes successfully saved";
    }
        
    // hisna_stevilka
    if (!empty($hisna_stevilka)) {
        $query = "SELECT fk_id_naslov FROM uporabnik WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $podatoci = mysqli_fetch_assoc($rezultat);
        $fk_id_naslov = $podatoci['fk_id_naslov'];
        $query = "UPDATE naslov SET hisna_stevilka='$hisna_stevilka' WHERE id_naslov='$fk_id_naslov'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION["napaka"] = "Changes successfully saved";
    }
    // mesto
    if (!empty($mesto)) {
        $query = "SELECT fk_id_naslov FROM uporabnik WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $podatoci = mysqli_fetch_assoc($rezultat);
        $fk_id_naslov = $podatoci['fk_id_naslov'];
        $query = "UPDATE naslov SET mesto='$mesto' WHERE id_naslov='$fk_id_naslov'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION["napaka"] = "Changes successfully saved";
    }
    // ulica
    if (!empty($ulica)) {
        $query = "SELECT fk_id_naslov FROM uporabnik WHERE id_uporabnik='$id_uporabnik'";
        $rezultat = mysqli_query($conn, $query);
        $podatoci = mysqli_fetch_assoc($rezultat);
        $fk_id_naslov = $podatoci['fk_id_naslov'];
        $query = "UPDATE naslov SET ulica='$ulica' WHERE id_naslov='$fk_id_naslov'";
        $rezultat = mysqli_query($conn, $query);
        $_SESSION["napaka"] = "Changes successfully saved";
    }
    header('Location: ' . "./prodajalecEditClient2.php?id_uporabnik=$id_uporabnik");
    exit();
?>
