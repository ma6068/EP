<?php
    include 'konekcija.php';
    $id_avto = $_GET["$id_avto"];
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<meta charset="utf-8">
	<title>Edit car</title>
        <link rel="stylesheet" type="text/css" href="./css/all.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body>
    <div>
        <div class="container spacing-bottom">
            <?php
                echo '<form class="form-signin" method="POST" action="./editAvtoController.php?id_avto=' . $id_avto . '">';
            ?>
            <div class=" row flex-center">
		<div class="col-md-4 oblik-prijava">
                    <div class=" mt-4">
			<div class="color-bukvi">
                            <h2 class="card-title mt-2 text-center">Edit car</h2>
			</div>
			<article class="card-body">
                            <form role="form">
                                <div class="form-group">
                                    <input id="marka" name="marka" placeholder="Brand" class="form-control" type="text" maxlength="20">
                                </div>
                                <div class="form-group">
                                    <input id="cena" name="cena" placeholder="Price in $" class="form-control" type="number" min="1" maxlength="10">
                                </div>
                                <div class="form-group">
                                    <input id="slika" name="slika" placeholder="Photo name" class="form-control" type="text" maxlength="20">
                                </div>
                                <div class="form-group">
                                    <input id="aktiven" name="aktiven" placeholder="Active-1 / Deactivated-2" class="form-control" type="number" min="1" maxlength="10">
                                </div>
                                <div class="form-group">
                                    <input id="opis" name="opis" placeholder="Description" class="form-control" type="text" maxlength="100">
                                </div>
				<div class="form-group" id="resetButton">
                                    <button class="btn btn-primary btn-block" type="submit">Save</button>
                                </div>
                                <?php
                                if(isset($_SESSION["napaka"])) {
                                    echo '<center><p id="reg_err">' . $_SESSION["napaka"] . '</p></center>';
                                    unset($_SESSION["napaka"]); 
                                }
                                ?>
                            </form>
                        </article>
                    </div>
                </div>
            </div>
          </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

</body>



</html>

<?php 

    $id_avto = $_GET["$id_avto"];
    
    $marka = $_POST["marka"];
    $cena = $_POST["cena"];
    $slika = $_POST["slika"];
    $aktiven = $_POST["aktiven"];
    $opis = $_POST["opis"];
    
    // ako ima prazno pole
    if (empty($marka) || empty($slika) || empty($opis) || empty($cena) || empty($aktiven)) {
        $_SESSION["napaka"] = "Please fill in all fields";
        header('Location: ' . "./editAvtoController.php?id_avto=' . $id_avto . '");
        //exit();
    }
    
    
    // ako aktiven gresno nastaveno
    if ($aktiven!=1 && $aktiven!=2) {
        $_SESSION["napaka"] = "Illegal activation value";
        //header('Location: ' . "./editAvtoController.php?id_avto=' . $id_avto . '");
        //exit();
    }
    
    
    // dodaj ja kolata 
    $query = "UPDATE avto "
            . "SET marka='$marka', cena='$cena', slika='$slika', aktiven='$aktiven' opis='$opis'"
            . "WHERE id_avto='$id_avto'";
    $rezultat = mysqli_query($conn, $query);
    $_SESSION["napaka"] = "Car successfully edited";
    //header('Location: ' . "./editAvtoController.php?id_avto=' . $id_avto . '");
    //exit();
    

?>


