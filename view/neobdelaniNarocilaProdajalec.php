<?php
    include 'konekcija.php';
    include 'prodajalecGlava.php';
    
    $query = "SELECT a.marka, a.cena, a.slika, a.opis, k.id_kosarica, k.datum, k.kolicina, u.ime, u.priimek, u.email, u.telefon "
            . "FROM avto a, kosarica k, kosarica_avto ka, uporabnik u "
            . "WHERE k.status='neobdelano' AND k.id_kosarica=ka.fk_id_k AND ka.fk_id_a=a.id_avto AND u.id_uporabnik=k.fk_id_uporabnik";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_num_rows($rezultat);
    
    if ($podatoci > 0) {
        $brojPoracka = 0;
        $idSega = '';
        $prvPodatok = 'da';
        while ($podatok = mysqli_fetch_assoc($rezultat)) {
           $imaPromena = 'ne';
            if ($idSega != $podatok['id_kosarica']) {
                if ($prvPodatok == 'ne') {
                    echo '<div style="margin-top: 5%"><h4>Total: '.$sum.' $</h4></div>
                            <a class="btn btn-primary" href="./potrdiAvto.php?id_kosarica=' . $idSega . '">Confirm</a>
                            <a class="btn btn-danger" href="./prekliciAvto.php?id_kosarica=' . $idSega . '">Cancel</a>';
                }
                $idSega = $podatok['id_kosarica'];
                $brojPoracka = $brojPoracka + 1;
                $imaPromena = 'da';
                $sum = 0;
            }
            $sum += $podatok['cena'] * $podatok['kolicina'];
            if ($imaPromena == 'da') {
                echo '<br></br><h3 align="center">Order number : '.$brojPoracka.'</h3>';
           }
           echo '<table align=center width="100%" border="0" cellpadding="100">
                    <tr>
                        <td align="center" valign="center">
                            <img class="group list-group-image" src="../images/' . $podatok['slika'] . '" alt="" />
                            <table style="width:100%">
                                <tr>
                                    <th>Brand</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                </tr>
                                <tr>
                                    <td>'.$podatok['marka'].'</td>
                                    <td>'.$podatok['opis'].'</td>
                                    <td>'.$podatok['cena'].'</td>
                                </tr>
                                <tr>
                                    <th>Order date</th>
                                    <th>Number of articles</th>
                                </tr>
                                <tr>
                                    <td>'.$podatok['datum'].'</td>
                                    <td>'.$podatok['kolicina'].'</td>
                                </tr>
                                <tr>
                                    <th>Client name</th>
                                    <th>Client surname</th>
                                    <th>Client email</th>
                                    <th>Client phone number</th>
                                </tr>
                                <tr>
                                    <td>'.$podatok['ime'].'</td>
                                    <td>'.$podatok['priimek'].'</td>
                                    <td>'.$podatok['email'].'</td>
                                    <td>'.$podatok['telefon'].'</td>
                                </tr>
                        </td>
                    </tr>
                </table>
                </form>';
            $prvPodatok = 'ne';
        }
        // za poslednata ispis 
        echo '<div style="margin-top: 5%"><h4>Total: '.$sum.' $</h4></div>
                <a class="btn btn-primary" href="./potrdiAvto.php?id_kosarica=' . $idSega . '">Confirm</a>
                <a class="btn btn-danger" href="./prekliciAvto.php?id_kosarica=' . $idSega . '">Cancel</a>';
    }
    // nema neobdelani podatoci
    else {
        echo '<h1>No unconfirmed orders</h1>';
    }
	
    mysqli_stmt_close($sql); 
    mysqli_close($conn);

?>