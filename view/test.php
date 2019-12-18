<?php
    session_start();
    include 'konekcija.php';
    
    $query = "SELECT * FROM uporabnik";
    $result = mysqli_query($conn, $query);
    $rows = mysqli_num_rows($result);
    
    if ($rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            //echo($row['id_uporabnik'] + " ");
            //echo($row['ime'] + " ");
            //echo($row['priimek'] + " ");
            //echo($row['telefon'] + " ");
            //echo($row['geslo'] + " ");
            echo($row['ime']);
            echo($row['priimek']);
            echo("\n");
        }
    }
?>

