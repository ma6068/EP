<?php
    include 'konekcija.php';
    session_start();
    
    $id_kosarica = $_GET["id_kosarica"];
    
    $query = "UPDATE kosarica SET status='preklicano' WHERE id_kosarica='$id_kosarica'";
    $rezultat = mysqli_query($conn, $query);
    header('Location: ' . "./neobdelaniNarocilaProdajalec.php");
?>
