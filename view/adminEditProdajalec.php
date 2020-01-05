<?php
    session_start();
    if($_SERVER["HTTPS"] != "on") {
	header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
    include 'konekcija.php';
    include 'adminGlava.php';
    
    $query = "SELECT * FROM uporabnik WHERE uloga='prodajalec'";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_num_rows($rezultat);
    
    if ($podatoci > 0) {
        while ($podatok = mysqli_fetch_assoc($rezultat)) {
           echo '<table align=center width="100%" border="0">
                    <tr>
                        <td align="center" valign="center">
                            <table style="width:100%">
                                <tr>
                                    <th>Seller\'s name</th>
                                    <th>Seller\'s surname</th>
                                    <th>Seller\'s email</th>
                                    <th>Status</th>
                                </tr>
                                <tr>
                                    <td>'.$podatok['ime'].'</td>
                                    <td>'.$podatok['priimek'].'</td>
                                    <td>'.$podatok['email'].'</td>
                                    <td>'.$podatok['status'].'</td>
                                </tr>
                        </td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="./adminEditProdajalec2.php?id_uporabnik=' . $podatok['id_uporabnik'] . '">Edit</a>
                </form>';
        }
    }
    // nema stranki
    else {
        echo '<h1>No sellers</h1>';
    }
	
    mysqli_stmt_close($sql); 
    mysqli_close($conn);

?>
