<?php
    include 'konekcija.php';
    include 'anonimenGlava.php';
    
    $query = "SELECT * FROM avto WHERE aktiven = '1'";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_num_rows($rezultat);
    
    if ($podatoci > 0) {
        while ($podatok = mysqli_fetch_assoc($rezultat)) {
           $akt = '';
           if ($podatok['aktiven'] == 1) {
               $akt = 'Yes';
           }
           else {
               $akt = 'No';
           }
           echo '<table align=center width="100%" border="0" cellpadding="5">
                    <tr>
                        <td align="center" valign="center">
                            <img class="group list-group-image" src="../images/' . $podatok['slika'] . '" alt="" />
                            <table style="width:100%">
                                <tr>
                                    <th>Brand</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Active</th>
                                </tr>
                                <tr>
                                    <td>'.$podatok['marka'].'</td>
                                    <td>'.$podatok['opis'].'</td>
                                    <td>'.$podatok['cena'].'</td>
                                    <td>'.$akt.'</td>
                                </tr>
                        </td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="./prijava.php">Add to Cart</a>';
        }
    }
    // nema neobdelani podatoci
    else {
        echo '<h1>No comfirmed orders</h1>';
    }
	
    mysqli_stmt_close($sql); 
    mysqli_close($conn);

?>
