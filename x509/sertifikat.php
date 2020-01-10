<?php 
    session_start();
    include 'konekcija.php';
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Avtorizacija na podlagi polj certifikata X.509</title>
    </head>
    <body>
        <?php
        // za da go zacuvame gesloto
        $_SESSION["geslo"] = iscisti(mysqli_real_escape_string($conn, $_POST["geslo"]));
        
        $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");

        if ($client_cert == null) {
            die('err: Spremenljivka SSL_CLIENT_CERT ni nastavljena.');
        }

        $cert_data = openssl_x509_parse($client_cert);
        
        $email = $cert_data['subject']['emailAddress'];
        
        // za da go zacuvame emailot
        $_SESSION['email'] = $email;
        
        header('Location: ' . "./prijavaAPController.php");
        ?>
    </body>
</html>
