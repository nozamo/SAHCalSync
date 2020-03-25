Gebruik:
Download XAMPP of iets dergelijks, of gebruik je eigen domein en download het volgende bestand:
https://github.com/nozamo/SAHCalSync/blob/master/sahkalender.zip

Pak het bestand uit en zet het bestand in je htdocs en doe vervolgens dit: Open F12 -> Network -> XHR.
Open dan SAH -> afspraken.
Dan zie je als het goed is een item staan genaamd 'list' of 'customer'.
Klik daarop. Als het goed is zie je de headers. Hier heb je de headers 'x-api-key'. Deze moet je kopieren.

Open Calender.php 
en vul daar de benodigde gegevens in (denk aan SAH email, WW, en API key)
Ga dan naar localhost (wss localhost/calendar.php)
Nu download als het goed is een ics file (als je met je telefoon op hetzelfde netwerk zit kun je via het IP van je computer naar de website gaan zodat je de ICS op je telefoon download).
Als deze gedownload is kun je als het goed is de ICS file importeren in je calendar / google calendar.
Doe dit niet als URL want het is niet veilig genoeg om blood aan het internet te stellen. Als hier bij SAH een alternatief voor wordt bedacht is het mogelijk om de calendars te synchroniseren via URL.

met dank aan AdventurePandah
