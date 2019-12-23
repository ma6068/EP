<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<meta charset="utf-8">
	<title>Prodajalec header</title>
        <link rel="stylesheet" type="text/css" href="./css/all.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body>
	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v5.0"></script>

	<div style="width: 100%">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
                                    <a class="nav-link" href="./editProdajalec.php">Edit profile<span class="sr-only"></span></a>
				</li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./neobdelaniNarocilaProdajalec.php">Unconfirmed orders<span class="sr-only"></span></a>
				</li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./obdelaniNarocilaProdajalec.php">Confirmed orders<span class="sr-only"></span></a>
				</li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./addAvto.php">Add car<span class="sr-only"></span></a>
				</li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./editAvto.php">Edit car<span class="sr-only"></span></a>
				</li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./prodajalecAddClient.php">Add client<span class="sr-only"></span></a>
				</li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./prodajalecADClient.php">Change client's status<span class="sr-only"></span></a>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0">
				<a class="nav-link" href="./odjava.php">Log out</a>
			</form>
		</div>
	</nav>
	
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js " integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN " crossorigin="anonymous "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js " integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4 " crossorigin="anonymous "></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js " integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1 " crossorigin="anonymous "></script>



</div>

</body>



</html>

