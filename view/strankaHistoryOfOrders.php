<?php
    include 'konekcija.php';
    include 'strankaGlava.php';
    
    $idUporabnik = $_SESSION['id_uporabnik'];
    $sum = 0;
    
    $query = "SELECT a.id_avto, a.marka, a.cena, a.opis, k.datum,k.status, ka.kolicina, k.id_kosarica "
            . "FROM avto a, kosarica k, kosarica_avto ka, uporabnik u "
            . "WHERE u.id_uporabnik='$idUporabnik' AND k.status!='oddano' AND k.id_kosarica=ka.fk_id_k AND ka.fk_id_a=a.id_avto AND u.id_uporabnik=k.fk_id_uporabnik";

    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_num_rows($rezultat);
    
    if ($podatoci > 0) {
        $brojPoracka = 0;
        $idSega = '';
        $prvPodatok = 'da';
        while ($podatok = mysqli_fetch_assoc($rezultat)) {
            $imaPromena = 'ne';
            if ($idSega != $podatok['id_kosarica']) {
                $idSega = $podatok['id_kosarica'];
                $brojPoracka = $brojPoracka + 1;
                $imaPromena = 'da';
                if ($prvPodatok == 'da') {
                    $prvPodatok = 'ne';
                }
                else {
                    echo '<div style="margin-top: 5%"><h4>Total: '.$sum.' $</h4></div>';
                    $sum = 0;
                }
            }
            $sum += $podatok['cena'] * $podatok['kolicina'];
            if ($imaPromena == 'da') {
                echo '<br></br><h3 align="center">Order number : '.$brojPoracka.'</h3>';
            }
            $id_avto = $podatok['id_avto'];
            echo '<div><table align=center width="100%" border="0" cellpadding="100">
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
                                    <th>Amount</th>
                                    <th>Date and time</th>
                                    <th>Status</th>
                                </tr>
                                <tr>
                                    <td>'.$podatok['marka'].'</td>
                                    <td>'.$podatok['opis'].'</td>
                                    <td>'.$podatok['cena'].' $</td>
                                    <td>'.$podatok['kolicina'].'</td>
                                    <td>'.$podatok['datum'].'</td>
                                    <td>'.$podatok['status'].'</td>
                                </tr>
                        </td>
                    </tr>
                </table>
                </div>';
        }
        // za poslednata ispis 
        echo '<div style="margin-top: 5%"><h4>Total: '.$sum.' $</h4></div>';
    }
    // history prazno
    else {
        echo '<h1>You haven\'t ordered anything</h1>';
    }
	
    mysqli_stmt_close($sql); 
    mysqli_close($conn);

?>
