<?php
    session_start();
    if($_SERVER["HTTPS"] != "on") {
	header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
    include 'konekcija.php';
    include 'strankaGlava.php';
    
    $id_uporabnik = $_SESSION['id_uporabnik'];
    $sum = 0;
      
    $query = "SELECT a.id_avto, a.marka, a.cena, a.opis, ka.kolicina, a.id_avto, k.id_kosarica "
            . "FROM avto a, kosarica k, kosarica_avto ka "
            . "WHERE k.fk_id_uporabnik='$id_uporabnik' AND k.status='oddano' AND k.id_kosarica=ka.fk_id_k AND ka.fk_id_a=a.id_avto";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_num_rows($rezultat);
    
    $prvPat = 'da';
    $id_kosarica = '';
    $counter = -1;
    //echo '<form action="kosaricaPotvrda.php" method="POST">';
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
                                    <th style="width: 20%">Amount</th>
                                    <div class="form-group"> 
                                       <a class="btn btn-primary" href="./avtoKolicina.php?id_avto=' . $podatok['id_avto'] . '">Change Amount</a>
                                     </div>
                                </tr>
                                <tr>
                                    <td style="width: 20%">'.$podatok['marka'].'</td>
                                    <td style="width: 20%">'.$podatok['opis'].'</td>
                                    <td style="width: 20%">'.$podatok['cena'].'</td>
                                    <td style="width: 20%">'.$podatok['kolicina'].'</td>
                                </tr>
                        </td>
                    </tr>
                </table>
                <a class="btn btn-danger" href="./kosaricaTrganjeKola.php?id_avto=' . $podatok['id_avto'] . '">Delete</a>
                ';
        }
        echo '<div style="margin-top: 5%"><h2>Total: '.$sum.'</h2></div>';
        echo '<div style="margin-top: 1%"><a class="btn btn-primary" href="./kosaricaPotvrda.php?id_kosarica=' . $id_kosarica . '">Confirm</a></div></form>';
    }
    // nema koli vo kosarica
    else {
        echo '<h1>You don\'t have car\'s on your cart</h1>';
    }
    if(isset($_SESSION["napaka"])) {
        echo '<center><p id="reg_err">' . $_SESSION["napaka"] . '</p></center>';
        unset($_SESSION["napaka"]); 
    }
    ?>
<?php
    mysqli_stmt_close($sql); 
    mysqli_close($conn);

?>