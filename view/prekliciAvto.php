<?php
    include 'konekcija.php';
    session_start();
    
    $id_kosarica = iscisti(mysqli_real_escape_string($conn, $_GET["id_kosarica"]));
    
    $query = "UPDATE kosarica SET status='preklicano' WHERE id_kosarica='$id_kosarica'";
    $rezultat = mysqli_query($conn, $query);
    header('Location: ' . "./neobdelaniNarocilaProdajalec.php");
?>
