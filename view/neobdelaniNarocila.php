<?php
    include 'konekcija.php';
    
    $query = "SELECT a.marka, a.cena, a.slika, a.opis "
            . "FROM avto a, kosarica k, kosarica_avto ka "
            . "WHERE k.status='neobdelano' AND k.id_kosarica=ka.fk_id_k AND ka.fk_id_a=a.id_avto";
    $rezultat = mysqli_query($conn, $query);
    $podatoci = mysqli_num_rows($rezultat);
    
    if ($podatoci > 0) {
        while ($podatok = mysqli_fetch_assoc($rezultat)) {
           echo '<div class="item  col-xs-12 col-sm-6 col-lg-3">
                    <div class="thumbnail">
			<img class="group list-group-image" src="./images/' . $slikaCol . '" alt="" />
                            <div class="caption">
				<h4 class="group inner list-group-item-heading">' . $nazivCol . '</h4>
                                    <p class="group inner list-group-item-text">
					' .$kopisCol . '</p>	
                                    <div class="row">
                                        <div class="col-xs-12 col-md-6">
					<p class="lead">
                                            € ' . $cenaCol . '</p>
					</div>			
					<div class="col-xs-12 col-md-6"> ';
                                            if(isset($_SESSION["rola"]) && $_SESSION["rola"] == 3) {
						echo '<a class="btn btn-success" href="./addToCart.php?idIzdelek=' . $idCol . '">Add to cart</a>';
                                            }
                                            else if(isset($_SESSION["rola"]) && $_SESSION["rola"] == 2) {
						echo '<a class="btn btn-success" href="./product.php?idIzdelek=' . $idCol .'">Edit</a>';
                                            }
						echo '</div>
					</div>
				</div>
                            </div>
                        </div>';
                }
    }
    // nema neobdelani podatoci
    else {
    }
	
    mysqli_stmt_close($sql); 
    mysqli_close($conn);

?>