<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        .message {
            border: 2px solid #000;
            padding: 40px;
            margin: 50px auto;
            max-width: 500px;
        }

        .header {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="message">
        <div class="header">REMATE HERMANOS GARCIA</div>
        <div class="header">{{ $auction->name }}</div>
        <p><strong>No hay tickets para generar</strong></p>
        <p>No se encontraron apuestas registradas en este remate.</p>
    </div>
</body>

</html>
