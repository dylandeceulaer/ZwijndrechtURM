# ZwijndrechtURM
Gebruikersrechtenbeheer tool voor openbaar bestuur. Opgebouwd o.b.v. de noden van Gemeente Zwijndrecht maar aanpasbaar en doortrekbaar naar andere openbare besturen.

## Concept
Een gemeentebestuur is vaak zeer complex qua gebruikersbeheer door de vele verschillende diensten die een gemeente aanbied. Vaak zit het gebruikersbeheer bij verschillende personen (ICT, algemeen directeur, personeelsdienst, communicatiedienst, financiendiest, diensthoofden) en op verschillende plaatsen (local, vlaams gebruikersbeer, federaal gebruikersbeheer, Rijksregister/KSZ) waardoor het up-to-date houden van een gebruikersrechtendatabank vaak onmogelijk is. Daarnaast loopt het toegang verlenen en afnemen bij in en uit diensten vaak ook niet optimaal.
Deze toepassing oogt de beide te combineren waardoor zowel de databank up-to-date houden als de procedures voor in en uit diensten beter zullen verlopen. Dit met behulp van vaste procedures, taken en flows die meteen aan de juiste personen worden toegewezen. 

## Technisch
Het project is volledig in PHP op basis van het Laravel framework. De conventies van het Laravel framework worden zo strikt mogelijk gevolgd zodat, mits wat kennis van PHP en Laravel, het makkelijk kan opgezet worden voor een ander bestuur.

## Getting started
### Database opzetten & LDAP configureren
Kopiëer '.envExample' naar '.env' en pas alle 'LDAP_' en 'DB_' parameters aan naar de juiste waarden (zie Laravel en adldap2 documentatie voor meer informatie)
De 'LDAP_SCOPE' parameters voorzien enkel authenticatie filtering, als een LDAP gebruiker niet tot 1 van deze groepen behoort zal de toegang geweigerd worden.
In '/database/csv' zitten csv's die de seed data bevatten voor testdata en de initiële data. Hiermee kan snel in bulk data geïmporteerd worden. Verwijder telkens Example van alle bestandsnamen. Bekijk de respectievelijke seeder class bestanden voor meer informatie over de csv's.
Via Laravel artisan moet de database opgezet worden en geseed worden met data:
'php artisan migrate:install && php artisan db:seed'