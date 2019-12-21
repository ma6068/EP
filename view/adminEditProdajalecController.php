<?php

    session_start();
    include 'konekcija.php';
    
    $ime = $_POST["ime"];
    $novoIme = $_POST["novoIme"];
    $priimek = $_POST["priimek"];
    $novPriimek = $_POST["novPriimek"];
    $email = $_POST["email"];
    $novEmail = $_POST["novEmail"];
    $geslo = $_POST["geslo"];
    $novoGeslo = $_POST["novoGeslo"];
    
    // ako ima prazno pole
    if (empty($ime) || empty($novoIme) || empty($priimek) || empty($novPriimek) 
            || empty($email) || empty($novEmail) || empty($geslo) || empty($novoGeslo)) {
        $_SESSION["napaka"] = "Please fill in all fields";
        header('Location: ' . "./adminEditProdajalec.php");
        exit();
    }
    
    // vidi dali imas uporabnik so takov email
    $query = "SELECT * FROM uporabnik WHERE email='$novEmail'";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
    $podatoci = mysqli_fetch_assoc($rezultat);
    if($brojPodatoci > 0 && $email != $novEmail) {
        mysqli_stmt_close($sql); 
        mysqli_close($conn);
        $_SESSION["napaka"] = "User with that email doesn't exists";
        header('Location: ' . "./prijava.php");
        exit();
    }
    
    
    // vidi dali toj prodavac postoi
    $query="SELECT id_uporabnik FROM uporabnik WHERE ime='$ime' AND priimek='$priimek' AND email='$email' AND geslo='$geslo' AND status='aktiven' AND uloga='prodajalec'";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
    $podatoci = mysqli_fetch_assoc($rezultat);
    
    // toj prodavac ne postoi 
    if ($brojPodatoci==0) {
        $_SESSION["napaka"] = "Seller does not exist";
        header('Location: ' . "./adminEditProdajalec.php");
        exit();
    }
        
    // toj prodavac postoi pa ke mu gi smenime podatocite
    $id=$podatoci['id_uporabnik'];
    $query = "UPDATE uporabnik SET ime='$novoIme', priimek='$novPriimek', email='$novEmail', geslo='$novoGeslo' WHERE id_uporabnik='$id'";
    $rezultat = mysqli_query($conn, $query);
    $_SESSION["napaka"] = "Changes successfully saved";
    header('Location: ' . "./adminEditProdajalec.php");
    exit();
    
?>

