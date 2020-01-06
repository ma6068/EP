<?php
    session_start();
    if($_SERVER["HTTPS"] != "on") {
	header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
    include 'konekcija.php';
    include 'prodajalecGlava.php';
    
    $query = "SELECT * FROM uporabnik WHERE uloga='stranka'";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_num_rows($rezultat);
    
    if ($podatoci > 0) {
        $akt = '';
        while ($podatok = mysqli_fetch_assoc($rezultat)) {
           if ($podatok['status'] == 'aktiven') {
               $akt = 'Active';
           }
           else {
               $akt = 'Deactivated';
           }
           echo '<table align=center width="100%" border="0">
                    <tr>
                        <td align="center" valign="center">
                            <table style="width:100%">
                                <tr>
                                    <th>Client name</th>
                                    <th>Client surname</th>
                                    <th>Client email</th>
                                    <th>Client phone number</th>
                                    <th>Status</th>
                                </tr>
                                <tr>
                                    <td>'.$podatok['ime'].'</td>
                                    <td>'.$podatok['priimek'].'</td>
                                    <td>'.$podatok['email'].'</td>
                                    <td>'.$podatok['telefon'].'</td>
                                    <td>'.$akt.'</td>
                                </tr>
                        </td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="./prodajalecEditClient2.php?id_uporabnik=' . $podatok['id_uporabnik'] . '">Edit</a>
                <a class="btn btn-primary" href="./prodajalecADClientController.php?id_uporabnik=' . $podatok['id_uporabnik'] . '">Change status</a>';
        }
    }
    // nema stranki
    else {
        echo '<h1>No clients</h1>';
    }
	
    mysqli_stmt_close($sql); 
    mysqli_close($conn);

?>