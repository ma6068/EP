<?php
    include 'konekcija.php';
    include 'prodajalecGlava.php';
    
    $query = "SELECT a.marka, a.cena, a.slika, a.opis, k.id_kosarica, k.datum, k.kolicina, u.ime, u.priimek, u.email, u.telefon "
            . "FROM avto a, kosarica k, kosarica_avto ka, uporabnik u "
            . "WHERE k.status='potrjeno' AND k.id_kosarica=ka.fk_id_k AND ka.fk_id_a=a.id_avto AND u.id_uporabnik=k.fk_id_uporabnik";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_num_rows($rezultat);
    
    if ($podatoci > 0) {
        while ($podatok = mysqli_fetch_assoc($rezultat)) {
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
                <a class="btn btn-primary" href="./stornirajAvto.php?id_kosarica=' . $podatok['id_kosarica'] . '">Reverse</a>
                </form>';
        }
    }
    // nema neobdelani podatoci
    else {
        echo '<h1>No comfirmed orders</h1>';
    }
	
    mysqli_stmt_close($sql); 
    mysqli_close($conn);

?>
