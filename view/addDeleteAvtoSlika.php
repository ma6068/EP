<?php
    include 'konekcija.php';
    include 'prodajalecGlava.php';
    
    $query = "SELECT * FROM avto";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_num_rows($rezultat);
    
    if ($podatoci > 0) {
        while ($podatok = mysqli_fetch_assoc($rezultat)) {
           $akt = '';
           $id_avto = $podatok['id_avto'];
           if ($podatok['aktiven'] == 1) {
               $akt = 'Yes';
           }
           else {
               $akt = 'No';
           }
           echo '<table align=center width="100%" border="0" cellpadding="5">
                    <tr>
                        <td align="center" valign="center">';
                            $query2 = "SELECT * FROM avto_slika WHERE fk_id_avto='$id_avto'";
                            $rezultat2 = mysqli_query($conn, $query2);
                            $podatoci2 = mysqli_num_rows($rezultat2);
                            while ($podatok2 = mysqli_fetch_assoc($rezultat2)) {
                                echo '<img class="group list-group-image" src="../images/' . $podatok2['slika'] . '.png" alt="" />';
                            }
                            echo '<table style="width:100%">
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

               <a class="btn btn-primary" href="./addAvtoSlika2.php?id_avto=' . $id_avto .'">Add photo</a>
               <a class="btn btn-danger" href="./deleteAvtoSlika2.php?id_avto=' . $id_avto .'">Delete photo</a>';
        }
    } 
    // nema neobdelani podatoci
    else {
        echo '<h1>No cars</h1>';
    }
    
    mysqli_stmt_close($sql); 
    mysqli_close($conn);

?>
