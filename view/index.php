<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Avtorizacija na podlagi polj certifikata X.509</title>
    </head>
    <body>
        <?php
        # Avtorizirani uporabniki (to navadno pride iz podatkovne baze)
        $authorized_users = ["Ana", "Admin"];

        # preberemo odjemačev certifikat
        $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");

        # in ga razčlenemo
        $cert_data = openssl_x509_parse($client_cert);
        
        # preberemo ime uporabnika (polje "common name")
        $commonname = $cert_data['subject']['CN'];

        # Če se ime nahaja na seznam avtoriziranih uporabnikov prikažemo čas.
        if (in_array($commonname, $authorized_users)) {
            echo "$commonname je avtoriziran uporabnik, zato vidi trenutni čas: " . date("H:i");
        } else {
        # Sicer časa ne prikažemo.
            echo "$commonname ni avtoriziran uporabnik in nima dostopa do ure";
        }

        # Celotna vsebina certifikata.
        echo "<p>Vsebina certifikata: ";
        var_dump($cert_data);
        ?>
    </body>
</html>
