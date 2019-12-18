<?php

    session_start();
    include 'konekcija.php';
    
    $postna_stevilka = $_POST["postna_stevilka"];
    $mesto = $_POST["mesto"];
    $ulica = $_POST["ulica"];
    $hisna_stevilka = $_POST["hisna_stevilka"];
    
    // ako se site prazni
    if (empty($postna_stevilka) || empty($mesto) || empty($ulica) || empty($hisna_stevilka)) {
        $_SESSION["napaka"] = "please fill all fields";
        header('Location: ' . "./editAdresa.php");
        exit();
    }
    
    // prvo treba da go najdeme id-to na adresata (go ima vo tabelata uporabnik)
    $sega = $_SESSION['id_uporabnik'];
    $query = "SELECT fk_id_naslov FROM uporabnik WHERE id_uporabnik='$sega'";
    $rezultat = mysqli_query($conn, $query);
    $brojPodatoci = mysqli_num_rows($rezultat);
    $podatoci = mysqli_fetch_assoc($rezultat);
    
    $kluc = $podatoci['fk_id_naslov'];
    
    // vo kluc ja go imame id-to, vo tabela naslov ja barame redicata so toa id za da gi smenime podatocite
    $query = "UPDATE naslov "
            . "SET postna_stevilka='$postna_stevilka', mesto='$mesto', ulica='$ulica', hisna_stevilka='$hisna_stevilka' "
            . "WHERE id_naslov='$kluc'";
    $rezultat = mysqli_query($conn, $query);
    $_SESSION["napaka"] = "Changes successfully saved";
    header('Location: ' . "./editAdresa.php");
    exit();
    
?>


