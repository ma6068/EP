<?php
    include 'konekcija.php';
    include 'strankaGlava.php';
    session_start();
    
    $id_uporabnik = $_SESSION['id_uporabnik'];
    $sum = 0;
      
    $query = "SELECT a.id_avto, a.marka, a.cena, a.opis, k.kolicina, a.id_avto, k.id_kosarica "
            . "FROM avto a, kosarica k, kosarica_avto ka "
            . "WHERE k.fk_id_uporabnik='$id_uporabnik' AND k.status='oddano' AND k.id_kosarica=ka.fk_id_k AND ka.fk_id_a=a.id_avto";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_num_rows($rezultat);
    
    $prvPat = 'da';
    $id_kosarica = '';
    $counter = -1;
    echo '<body><div><form action="kosaricaPotvrda.php" method="POST">';
    if ($podatoci > 0) {
        while ($podatok = mysqli_fetch_assoc($rezultat)) {
            $counter = $counter + 1;
            if ($prvPat == 'da') {
                $prvPat = 'ne';
                $id_kosarica = $podatok['id_kosarica'];
                $_SESSION['id_kosarica'] = $podatok['id_kosarica'];
            }
            $sum += ( $podatok['cena'] * $podatok['kolicina'] );
            $id_avto = $podatok['id_avto'];
            echo '
                <div>
                <table align=center width="100%" border="0" cellpadding="100">
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
                                    <th style="width: 20%">Brand</th>
                                    <th style="width: 20%">Description</th>
                                    <th style="width: 20%">Price</th>
                                </tr>
                                <tr>
                                    <td style="width: 20%">'.$podatok['marka'].'</td>
                                    <td style="width: 20%">'.$podatok['opis'].'</td>
                                    <td style="width: 20%">'.$podatok['cena'].'</td>
                                </tr>
                        </td>
                    </tr>
                </table>
                  <div class="form-group">
                        Amount
                        <input id="kolicina" name="kolicina['.$counter.']" class="form-control mr-sm-2" style="width: 20%" type="number" value="1" min="1" placeholder="Amount" aria-label="Search" style="width: 50%">
                    </div>
                <a class="btn btn-danger" href="./kosaricaTrganjeKola.php?id_avto=' . $podatok['id_avto'] . '">Delete</a>
                ';
        }
        echo '<div style="margin-top: 5%"><h2>Total: '.$sum.'</h2></div>';
        echo '<div style="margin-top: 1%"><a class="btn btn-primary" href="./kosaricaPotvrda.php?id_kosarica=' . $id_kosarica . '">Confirm</a></div></form></div></body>';
    }
    // nema koli vo kosarica
    else {
        echo '<h1>You don\'t have car\'s on your cart</h1>';
    }
	
    mysqli_stmt_close($sql); 
    mysqli_close($conn);

?>