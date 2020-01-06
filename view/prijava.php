<?php
   session_start();
    if($_SERVER["HTTPS"] != "on") {
	header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }	
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<meta charset="utf-8">
	<title>Login</title>
        <link rel="stylesheet" type="text/css" href="./css/all.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body>
    <?php include 'anonimenGlava.php';?>
    <div class="spacing-bottom">
        <div class="container">
            <form class="form-signin" method="POST" action="prijavaController.php">
		<div class=" row flex-center">
                    <div class="col-md-4 oblik-prijava">
			<div class=" mt-4">
                            <div class="color-bukvi">
                               <h2 class="card-title mt-2 text-center">Login</h2>
                            </div>
                            <article class="card-body">
				<form role="form">
				<div class="form-group">
                                    <input id="email" name="email" placeholder="E-mail" class="form-control" type="email" maxlength="30">
				</div>
				<div class="form-group">
                                    <input id="password" name="geslo" placeholder="Password" class="form-control" type="password" maxlength="30">
				</div>
                                <div class="form-group" id="loginButton">
                                    <button class="btn btn-primary btn-block" type="submit">Login</button>
				</div>
				<div class="form-group">
                                    <p>Don't have an account? <a href="/netbeans/EP/view/registracija.php">Create one!</a></p>
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
                </from>
            </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>



</body>



</html>
