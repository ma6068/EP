Ta naloga zahteva, da imate ustrezno nastavljena strežnik ter odjemalec.

Na strežniku morate imeti nameščeno strežniško digitalno potrdilo,
ki ga je izdala certifikatna agencija EPCA, v brskalniku pa morate
imeti nameščeno digitalno potrdilo certifikatne agencije EPCA kot
zaupanja vredne avtoritete, hkrati pa je potrebno imeti nameščeni
še osebni digitalni potrdili za uporabnika Ana in Bojan.

Uporabite digitalna potrdila iz projekta certs, ki jih namestite
skladno s spodnjimi navodili.

* Datoteke s koncnico `.p12` vsebujejo osebne certifikate. Uvozite jih v
  brskalnik. Geslo za uvoz je `ep`.

* Datoteki `localhost-cert.pem` ter `localhost-key.pem` predstavljata strežnikov
  certifikat oz. zasebni ključ. Namestite ju v ustrezno mapo (denimo
  `/etc/apache2/ssl`), nato pa v konfiguracijsko datoteko strežnika Apache2
  (`/etc/apache2/sites-available/default-ssl.conf`) dodajte direktivi
  `SSLCertificateFile` oz. `SSLCertificateKeyFile`, ki kažeta na omenjeni
  datoteki.

* Datoteka `epca-cacert.pem` predstavlja certifikat certifikatne agencije EPCA,
  ki je podpisala vse certifikate. Njeno lokacijo najavite strežniku Apache2 v
  konfiguracijski datoteki z ukazom `SSLCACertificateFile /pot/do/epca-cacert.pem`.

  Pravtako morate ta certifikat uvoziti v brskalnik kot zaupanja vredno
  avtoriteto za identifikacijo spletnih strani.

* Datoteka `epca-crl.pem` predstavlja seznam preklicanih digitalnih potrdil.
  Njeno lokacijo prijavite v konfiguracijsko datoteko strežnika Apache2 z
  ukazom `SSLCARevocationFile /pot/do/epca-crl.pem`.

* Za pravilno delovanje datotek `.htaccess` mora biti vklopljen modul `rewrite`.
  Slednje storite z ukazom `sudo a2enmod rewrite`.

  Nato pa v datoteki `/etc/apache2/sites-available/{000-default,default-ssl}.conf`
  pod vrstico `Alias /netbeans ...` dodamo spodnjo vsebino

  ```
  Alias /netbeans/ "/home/ep/NetBeansProjects/"
  <Directory /home/ep/NetBeansProjects/>
        Require all granted
        AllowOverride All
  </Directory>
  ```