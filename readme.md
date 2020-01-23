Gebruik:
Download XAMPP of iets dergelijks, download het volgende bestand:
https://github.com/.../SAHCalSync/blob/master/calendar.php

Doe dit vervolgens: Open F12 -> Network -> XHR.
Open dan SAH -> afspraken.
Dan zie je als het goed is een item staan genaamd 'list' of 'customer'.
Klik daarop. Als het goed is zie je de headers. Hier heb je de headers 'idtoken' en 'x-api-key'. Deze twee moet je kopieren.

Ga dan naar localhost/calendar.php?id=YOUR_ID_TOKEN&api=YOUR_API_KEY.
Nu download als het goed is een ics file (als je met je telefoon op hetzelfde netwerk zit kun je via het IP van je computer naar de website gaan zodat je de ICS op je telefoon download).
Als deze gedownload is kun je als het goed is de ICS file importeren in je calendar / google calendar.
Doe dit niet als URL want je idtoken veranderd om de zoveel tijd. Als hier bij SAH een alternatief voor wordt bedacht is het mogelijk om de calendars te synchroniseren via URL.
