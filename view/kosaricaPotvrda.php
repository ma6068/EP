<?php
    include 'konekcija.php';
    session_start();
    
    $id_kosarica = $_GET['id_kosarica'];
        
    $query = "UPDATE kosarica SET status='neobdelano' WHERE id_kosarica='$id_kosarica'";
    $rezultat = mysqli_query($conn, $query);
    $_SESSION["napaka"] = "Order successfully completed";
    header('Location: ' . "./strankaKosarica.php");
    exit();
?>