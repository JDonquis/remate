```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Remate - {{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: #FDFDFC;
            color: #1b1b18;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .dark body {
            background-color: #0a0a0a;
            color: #EDEDEC;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto 20px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-container svg {
            width: 40px;
            height: 40px;
        }

        .store-name {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .create-button,
        .save-button {
            background-color: #424b98;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .create-button:hover,
        .save-button:hover {
            background-color: #e0c91b;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .main-content {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            flex-grow: 1;
        }

        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid #f0f0f0;
        }

        .dark .form-container {
            background-color: #161615;
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.05);
            border-color: #2a2a2a;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #424b98;
            font-size: 1.1rem;
        }

        .dark .form-group label {
            color: #e0c91b;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e3e3e0;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: all 0.3s ease;
            background-color: #fafafa;
            font-family: 'Instrument Sans', sans-serif;
        }

        .form-group input:focus {
            outline: none;
            border-color: #424b98;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(66, 75, 152, 0.1);
        }

        .dark .form-group input {
            background-color: #2a2a2a;
            border-color: #3E3E3A;
            color: #EDEDEC;
        }

        .dark .form-group input:focus {
            border-color: #e0c91b;
            background-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(224, 201, 27, 0.1);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }

        .cancel-button {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .cancel-button:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Estilos para el placeholder */
        input::placeholder {
            color: #999;
            opacity: 1;
        }

        .dark input::placeholder {
            color: #777;
        }

        /* Estilos para números */
        input[type="number"] {
            -moz-appearance: textfield;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body class="flex flex-col items-center">
    <header class="header">
        <div class="logo-container">
            <div class="logo"></div>
            <span class="store-name">REMATE HERMANOS GARCIA</span>
        </div>
        <div>
            <a href="{{ route('auctions.index') }}" class="create-button">Volver al Listado</a>
        </div>
    </header>
    <div class="main-content">
        <form action="{{ route('auctions.store') }}" method="POST" id="auctionForm">
            @csrf
            <div class="form-container">
                <div class="form-group">
                    <label for="auction_name">Nombre del Remate</label>
                    <input type="text" id="auction_name" name="name" value="{{ $nextName }}" required
                        placeholder="Ingrese el nombre del remate">
                </div>
                <div class="form-group">
                    <label for="additional_pot">Pote Adicional</label>
                    <input type="number" id="additional_pot" name="additional_pot" placeholder="0.00" min="0"
                        step="0.01" value="0">
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('auctions.index') }}" class="cancel-button">Cancelar</a>
                <button type="submit" class="save-button">Guardar Remate</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const auctionForm = document.getElementById('auctionForm');
            const auctionNameInput = document.getElementById('auction_name');

            // Manejar el envío del formulario
            auctionForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validar que el nombre no esté vacío
                if (!auctionNameInput.value.trim()) {
                    alert('El nombre del remate es obligatorio.');
                    return;
                }

                // Enviar el formulario
                this.submit();
            });
        });
    </script>
</body>

</html>
```
