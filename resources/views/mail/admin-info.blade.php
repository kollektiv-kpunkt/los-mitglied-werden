<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: sans-serif;
        }
    </style>
</head>
<body>
    <p><em>--------&nbsp;Fran&ccedil;ais ci-dessous&nbsp;--------</em></p>
    <p>Hoi!</p>

    <p>Es gab einen neuen Eintrag &uuml;ber das Mitgliederformular der LOS.</p>

    @if (isset($supporter->data["membertype"]))
        <p>Bei diesem Eintrag handelt es sich um <b>ein Mitglied.</b> Hier die Details:</p>
    @else
        <p>Bei diesem Eintrag handelt es sich um <b>eine*n Unterstützer*in.</b> Hier die Details:</p>
    @endif

    <ul>
        <li><strong>Vorname:</strong> {{$supporter->data["fname"]}}</li>
        <li><strong>Nachname:</strong> {{$supporter->data["lname"]}}</li>
        <li><strong>E-Mail:</strong> {{$supporter->data["email"]}}</li>
        @if (isset($supporter->data["address"]))
            <li><strong>Adresse:</strong> {{$supporter->data["address"]}}</li>
        @endif
        @if (isset($supporter->data["membertype"]))
            <li><strong>Mitgliedschaftstyp:</strong> {{$supporter->data["membertype"]}}</li>
        @endif
        @if (isset($supporter->data["volunteertype"]))
            <li><strong>Volunteer-Typ:</strong> {{implode(", ", $supporter->data["volunteertype"])}}</li>
        @endif
    </ul>

    <p>Weitere Infos zum Mitglied findest du hier: <a href="https://swisslesbianorganisationlos2.lightning.force.com/lightning/r/Contact/{{$salesforceID}}/view">https://swisslesbianorganisationlos2.lightning.force.com/lightning/r/Contact/{{$salesforceID}}/view</a></p>

    <p>Bei Fragen zu dieser E-Mail, wende dich an <a href="mailto:timothy@kpunkt.ch">Timothy Oesch</a>. Liebe Gr&uuml;sse</p>

    <p>&nbsp;</p>

    <p>_________________________________</p>

    <p>Salut !</p>

    <p>Il y a eu une nouvelle entr&eacute;e via le formulaire de membre de la LOS.</p>

    @if (isset($supporter->data["membertype"]))
        <p>Cette entrée est celle d'un*e membre</b> En voici les d&eacute;tails :</p>
    @else
        <p>Cette entrée est celle d'une supportrice</b> En voici les d&eacute;tails :</p>
    @endif

    <ul>
        <li><strong>Pr&eacute;nom :&nbsp;</strong> {{$supporter->data["fname"]}}</li>
        <li><strong>Nom de famille :</strong> {{$supporter->data["lname"]}}</li>
        <li><strong>E-mail :</strong> {{$supporter->data["email"]}}</li>
        @if (isset($supporter->data["address"]))
            <li><strong>Adresse:</strong> {{$supporter->data["address"]}}</li>
        @endif
        @if (isset($supporter->data["membertype"]))
            <li><strong>Type de membre :</strong> {{$supporter->data["membertype"]}}</li>
        @endif
        @if (isset($supporter->data["volunteertype"]))
            <li><strong>Volunteer-Typ:</strong> {{implode(", ", $supporter->data["volunteertype"])}}</li>
        @endif
    </ul>

    <p>Tu trouveras plus d&#39;informations sur le membre ici : <a href="https://swisslesbianorganisationlos2.lightning.force.com/lightning/r/Contact/{{$salesforceID}}/view">https://swisslesbianorganisationlos2.lightning.force.com/lightning/r/Contact/{{$salesforceID}}/view</a></p>

    <p>Si tu as des questions sur cet e-mail, adresse-toi &agrave; <a href="mailto:timothy@kpunkt.ch">Timothy Oesch</a>. Amiti&eacute;s</p>

    <p>&nbsp;</p>

</body>
</html>
