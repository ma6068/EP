<?php
    include 'konekcija.php';
    include 'prodajalecGlava.php';
    session_start();
    $_SESSION['id_uporabnik'] = $_GET["id_uporabnik"];
?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/all.css">
    <meta charset="utf-8">
    <title>Prodajalec add Client</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body>
    <div>
        <form action="prodajalecEditClientController.php" method="POST">
        <div class="container spacing-bottom">
            <div class=" row flex-center">
                <div class="col-md-4 oblik-prijava">
                    <div class=" mt-4">
                        <div class="color-bukvi">
                            <h2 class="card-title mt-2 text-center">Edit client</h2>
                        </div>
                        <article class="card-body">
                                <div class="form-group">
                                    <input id="name" name="ime" placeholder="New name" class="form-control" type="text" maxlength="20">
                                </div>
                                <div class="form-group">
                                    <input id="surname" name="priimek" placeholder="New surname" class="form-control" type="text" maxlength="20">
                                </div>
                                <div class="form-group">
                                    <input id="postna_stevilka" name="postna_stevilka" placeholder="New postal code" class="form-control" type="number" maxlength="4">
                                </div>
                                <div class="form-group">
                                    <input id="mesto" name="mesto" placeholder="New city" class="form-control" type="text" maxlength="30">
                                </div>
                                <div class="form-group">
                                    <input id="ulica" name="ulica" placeholder="New Street" class="form-control" type="text" maxlength="30">
                                </div>
                                <div class="form-group">
                                    <input id="hisna_stevilka" name="hisna_stevilka" placeholder="New street Number" class="form-control" type="text" maxlength="30">
                                </div>
                                <div class="form-group" id="PhoneNumber">
                                    <input id="telefon" name="telefon" placeholder="New phone number" class="form-control" type="text" maxlength="30">
                                </div>
                                <div class="form-group">
                                    <input id="email" name="email" placeholder="New e-mail" class="form-control" type="email" maxlength="30">
                                </div>
                                <div class="form-group">
                                    <input id="geslo" name="geslo" placeholder="New password" class="form-control" type="password" maxlength="30">
                                </div>
                                <div class="form-group" id="dugme">
                                    <button class="btn btn-primary btn-block" type="submit"> Edit</button>
                            <?php
				if(isset($_SESSION["napaka"])) {
                                    echo '<center><p id="reg_err">' . $_SESSION["napaka"] . '</p></center>';
                                    unset($_SESSION["napaka"]); 
				}
                            ?>
                        </article>
                    </div>
                </div>
            </div>
        </div>
       </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>


</body>



</html>