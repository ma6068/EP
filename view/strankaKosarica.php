<?php
    include 'konekcija.php';
    include 'strankaGlava.php';
    session_start();
    
    $id_uporabnik = $_SESSION['id_uporabnik'];
    $sum = 0;
      
    $query = "SELECT a.marka, a.cena, a.slika, a.opis, k.kolicina, a.id_avto, k.id_kosarica "
            . "FROM avto a, kosarica k, kosarica_avto ka "
            . "WHERE k.fk_id_uporabnik='$id_uporabnik' AND k.status='oddano' AND k.id_kosarica=ka.fk_id_k AND ka.fk_id_a=a.id_avto";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_num_rows($rezultat);
    
    $prvPat = 'da';
    $id_kosarica = '';
    if ($podatoci > 0) {
        while ($podatok = mysqli_fetch_assoc($rezultat)) {
            if ($prvPat == 'da') {
                $prvPat = 'ne';
                $id_kosarica = $podatok['id_kosarica'];
                $_SESSION['id_kosarica'] = $podatok['id_kosarica'];
            }
            $sum += ( $podatok['cena'] * $podatok['kolicina'] );
            echo '
                <div><table align=center width="100%" border="0" cellpadding="100">
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
                                        <form method="POST" action="kosaricaPotvrda.php">
                                        <input class="form-control mr-sm-2" type="number" min="1" name="broj" placeholder="Amount" aria-label="Search" style="width: 50%">
                                        </form>
                                    </td>
                                </tr>
                        </td>
                    </tr>
                </table>
                <a class="btn btn-danger" href="./kosaricaTrganjeKola.php?id_avto=' . $podatok['id_avto'] . '">Delete</a>
                </div>
                ';
        }
        echo '<div style="margin-top: 5%"><h2>Total: '.$sum.'</h2></div>';
        echo '<div style="margin-top: 1%"><a class="btn btn-primary" href="./kosaricaPotvrda.php?id_kosarica=' . $id_kosarica . '">Confirm</a></div>';
    }
    // nema koli vo kosarica
    else {
        echo '<h1>You don\'t have car\'s on your cart</h1>';
    }
	
    mysqli_stmt_close($sql); 
    mysqli_close($conn);

?>