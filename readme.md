Nieuwe methode:
Voor de nieuwe methode heb je een linux nas/online webhosting/vps nodig die curl commands voor je kan uitvoeren om de zoveel tijd.
als je voor deze optie kiest ga ik er ook vanuit dat je weet wat je doet.

Stap 1. Je download het zip bestand van mijn github.
Stap 2. Pak het bestand uit en zet het bestand in je htdocs en doe vervolgens dit: Open F12 -> Network -> XHR.
Open dan SAH -> afspraken.
Dan zie je als het goed is een item staan genaamd 'list' of 'customer'.
Klik daarop. Als het goed is zie je de header. Hier heb je de headers 'x-api-key'. Deze moet je kopieren.
Stap 3. Past de variablen aan zodat ze overeen komen met jouw gegevens.
Stap 4. Maak een corn job aan die zich om de zoveel uur herhaald op je linux machine, met behulp van het scriptje.
Stap 5. Zorg dat jij je ical bestand download naar een openbare plek van de server (htdocs)                                              Je moet namelijk je php bestand en je ical bestand goed scheiden van elkaar.
(Het php bestand mag dus eigenlijk alleen intern toegankelijk zijn omdat dit een grote security lek kan zijn) 
Stap 6. The fun part, je kopieert nu de openbare link van je ical bestand en plakt die in je calendar naar keuze 
(nu kun je het gebruiken zoals het altijd al geweest was)
(ik ben niet verantwoordelijk voor de schade die je eventueel zelf kan aanbrengen)

Oude methode:
Gebruik:
Download XAMPP of iets dergelijks, of gebruik je eigen domein en download het volgende bestand:
https://github.com/nozamo/SAHCalSync/blob/master/sahkalender.zip

Pak het bestand uit en zet het bestand in je htdocs en doe vervolgens dit: Open F12 -> Network -> XHR.
Open dan SAH -> afspraken.
Dan zie je als het goed is een item staan genaamd 'list' of 'customer'.
Klik daarop. Als het goed is zie je de header. Hier heb je de headers 'x-api-key'. Deze moet je kopieren.

Open Calender.php 
en vul daar de benodigde gegevens in (denk aan SAH email, WW, en API key)
Ga dan naar localhost (wss localhost/calendar.php)
Nu download als het goed is een ics file (als je met je telefoon op hetzelfde netwerk zit kun je via het IP van je computer naar de website gaan zodat je de ICS op je telefoon download).
Als deze gedownload is kun je als het goed is de ICS file importeren in je calendar / google calendar.
Doe dit niet als URL want het is niet veilig genoeg om blood aan het internet te stellen. Als hier bij SAH een alternatief voor wordt bedacht is het mogelijk om de calendars te synchroniseren via URL.

met dank aan AdventurePandah
