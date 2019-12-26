<?php
    include 'konekcija.php';
    include 'strankaGlava.php';
    
    $idUporabnik = $_SESSION['id_uporabnik'];
    $sum = 0;
    
    $query = "SELECT a.marka, a.cena, a.slika, a.opis, k.id_kosarica, k.datum, k.kolicina, u.ime, u.priimek, u.email, u.telefon "
            . "FROM avto a, kosarica k, kosarica_avto ka, uporabnik u "
            . "WHERE u.id_uporabnik=$idUporabnik AND k.status='neobdelano' AND k.id_kosarica=ka.fk_id_k AND ka.fk_id_a=a.id_avto AND u.id_uporabnik=k.fk_id_uporabnik";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_num_rows($rezultat);
    
    if ($podatoci > 0) {
        while ($podatok = mysqli_fetch_assoc($rezultat)) {
            $sum += ( $podatok['cena'] * $podatok['kolicina'] );
            echo '<div><table align=center width="100%" border="0" cellpadding="100">
                    <tr>
                        <td align="center" valign="center">
                            <img class="group list-group-image" src="../images/' . $podatok['slika'] . '" alt="" />
                            <table style="width:100%">
                                <tr>
                                    <th style="width: 20%">Brand</th>
                                    <th style="width: 20%">Description</th>
                                    <th style="width: 20%">Price</th>
                                    <th style="width: 20%">Amount</th>
                                </tr>
                                <tr>
                                    <td style="width: 20%">'.$podatok['marka'].'</td>
                                    <td style="width: 20%">'.$podatok['opis'].'</td>
                                    <td style="width: 20%">'.$podatok['cena'].'</td>
                                    <td style="width: 20%">
                                        <input class="form-control mr-sm-2" type="number" name="broj" placeholder="Amount" aria-label="Search" style="width: 50%">
                                    </td>
                                </tr>
                        </td>
                    </tr>
                </table>
                <a class="btn btn-danger" href="./prekliciAvto.php?id_kosarica=' . $podatok['id_kosarica'] . '">Delete</a>
                </div>';
        }
        echo '<div style="margin-top: 5%"><h2>Total: '.$sum.'</h2></div>';
        echo '<div style="margin-top: 1%"><a class="btn btn-primary" href="./potrdiAvto.php?id_kosarica=' . $podatok['id_kosarica'] . '">Confirm</a></div>';
    }
    // nema neobdelani podatoci
    else {
        echo '<h1>No uncomfirmed orders</h1>';
    }
	
    mysqli_stmt_close($sql); 
    mysqli_close($conn);

?>