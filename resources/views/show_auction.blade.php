<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ver Remate - {{ config('app.name', 'Laravel') }}</title>
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
            max-width: 1600px;
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
        .print-all-button,
        .update-tab-button,
        .add-bet-button,
        .generate-ticket-button,
        .print-tickets-button {
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
        .print-all-button:hover,
        .update-tab-button:hover,
        .add-bet-button:hover,
        .generate-ticket-button:hover,
        .print-tickets-button:hover {
            background-color: #e0c91b;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .generate-ticket-button {
            padding: 5px 10px;
            font-size: 0.8rem;
        }

        .main-content {
            width: 100%;
            max-width: 24000px;
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

        .auction-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #424b98;
            margin-bottom: 25px;
        }

        .dark .auction-info {
            background-color: #2a2a2a;
            border-left-color: #e0c91b;
        }

        .auction-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: #424b98;
            margin-bottom: 10px;
        }

        .dark .auction-name {
            color: #e0c91b;
        }

        .auction-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.9rem;
            color: #666;
            font-weight: 500;
        }

        .dark .detail-label {
            color: #aaa;
        }

        .detail-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1b1b18;
        }

        .dark .detail-value {
            color: #EDEDEC;
        }

        .tab-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid #f0f0f0;
        }

        .dark .tab-container {
            background-color: #161615;
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.05);
            border-color: #2a2a2a;
        }

        .tab-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .tab-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #424b98;
        }

        .dark .tab-title {
            color: #e0c91b;
        }

        .update-tab-button.hidden {
            display: none;
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

        .print-all-button {
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .print-all-button:hover {
            background-color: #e0c91b;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .print-icon {
            margin-right: 8px;
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .generate-bet-ticket-button {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .generate-bet-ticket-button:hover {
            background-color: #218838;
            transform: translateY(-1px);
        }

        .generate-bet-ticket-button.loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Estilos para la tabla */
        .bets-table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        .bets-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
        }

        .bets-table th,
        .bets-table td {
            padding: 12px 8px;
            text-align: left;
            border-bottom: 1px solid #e3e3e0;
        }

        .bets-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #424b98;
            position: sticky;
            top: 0;
        }

        .dark .bets-table th {
            background-color: #2a2a2a;
            color: #e0c91b;
        }

        .bets-table tr:hover {
            background-color: rgba(66, 75, 152, 0.05);
        }

        .dark .bets-table tr:hover {
            background-color: rgba(224, 201, 27, 0.1);
        }

        .horse-number-cell {
            width: 40px;
            text-align: center;
            font-weight: 700;
            color: #D35400;
            /* Naranja oscuro */
            font-size: 1.2rem;
        }

        .dark .horse-number-cell {
            color: #E67E22;
            /* Naranja más claro para modo oscuro */
        }

        .horse-name-cell {
            font-weight: 700;
            min-width: 150px;
        }

        .horse-name-input {
            font-size: 1.2rem;
            font-weight: 700;
            color: #D35400;
            /* Naranja oscuro */
            border: 2px solid #E67E22;
            background-color: #FFF9F2;
            /* Fondo muy claro naranja */
        }

        .horse-name-input:focus {
            border-color: #D35400;
            background-color: #FFF5E6;
            box-shadow: 0 0 0 3px rgba(211, 84, 0, 0.1);
        }

        .dark .horse-name-input {
            color: #E67E22;
            background-color: #2D1B06;
            border-color: #F39C12;
        }

        .dark .horse-name-input:focus {
            background-color: #3E2408;
            border-color: #E67E22;
        }

        .tab-column {
            border-left: 2px solid #e3e3e0;
            min-width: 200px;
        }

        .tab-header-cell {
            text-align: center;
            font-weight: 600;
            background-color: #f0f0f0;
            font-size: 1.1rem;
        }

        .dark .tab-header-cell {
            background-color: #333;
        }

        .bet-input {
            width: 95%;
            padding: 8px 10px;
            border: 1px solid #e3e3e0;
            border-radius: 4px;
            font-size: 1.2rem;
            transition: all 0.2s ease;
            background-color: #fafafa;
            font-family: 'Instrument Sans', sans-serif;
        }

        .bet-input:focus {
            outline: none;
            border-color: #424b98;
            background-color: white;
            box-shadow: 0 0 0 2px rgba(66, 75, 152, 0.1);
        }

        .dark .bet-input {
            background-color: #2a2a2a;
            border-color: #3E3E3A;
            color: #EDEDEC;
        }

        .dark .bet-input:focus {
            border-color: #e0c91b;
            background-color: #1a1a1a;
            box-shadow: 0 0 0 2px rgba(224, 201, 27, 0.1);
        }

        .bet-person {
            font-size: 1.5rem;
            font-weight: 700;
            color: #D35400;
            /* Naranja oscuro */
            background-color: #FFF9F2;
            border: 2px solid #E67E22;
        }

        .bet-person:focus {
            border-color: #D35400;
            background-color: #FFF5E6;
            box-shadow: 0 0 0 3px rgba(211, 84, 0, 0.1);
        }

        .dark .bet-person {
            color: #E67E22;
            background-color: #2D1B06;
            border-color: #F39C12;
        }

        .dark .bet-person:focus {
            background-color: #3E2408;
            border-color: #E67E22;
        }

        .bet-amount-input {
            width: 80px;
            font-size: 1.5rem;
            font-weight: 700;
            color: #D35400;
            /* Naranja oscuro */
            background-color: #FFF9F2;
            border: 2px solid #E67E22;
        }

        .bet-amount-input:focus {
            border-color: #D35400;
            background-color: #FFF5E6;
            box-shadow: 0 0 0 3px rgba(211, 84, 0, 0.1);
        }

        .dark .bet-amount-input {
            color: #E67E22;
            background-color: #2D1B06;
            border-color: #F39C12;
        }

        .dark .bet-amount-input:focus {
            background-color: #3E2408;
            border-color: #E67E22;
        }

        .winner-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
            margin: 0 auto;
            display: block;
        }

        /* Cálculos por Tab - Nuevo diseño */
        .calculations-section {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .calculation-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            border-left: 4px solid #424b98;
        }

        .dark .calculation-card {
            background-color: #2a2a2a;
            border-left-color: #e0c91b;
        }

        .calculation-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #424b98;
            margin-bottom: 10px;
            text-align: center;
        }

        .dark .calculation-card-title {
            color: #e0c91b;
        }

        .calculation-details {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .calculation-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 0;
            border-bottom: 1px solid #e3e3e0;
        }

        .calculation-row:last-child {
            border-bottom: none;
        }

        .calculation-label {
            font-size: 0.8rem;
            color: #666;
            font-weight: 500;
        }

        .dark .calculation-label {
            color: #aaa;
        }

        .calculation-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1b1b18;
        }

        .dark .calculation-value {
            color: #EDEDEC;
        }

        .calculation-total {
            font-size: 1.1rem;
            font-weight: 700;
            margin-top: 5px;
            padding-top: 5px;
            border-top: 2px solid #424b98;
        }

        .dark .calculation-total {
            border-top-color: #e0c91b;
        }

        .add-horse-button {
            background-color: #424b98;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            margin-top: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .add-horse-button:hover {
            background-color: #e0c91b;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }

        .delete-horse-button {
            background-color: transparent;
            border: none;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .delete-horse-button:hover {
            background-color: rgba(244, 67, 54, 0.1);
            transform: scale(1.1);
        }

        .delete-horse-button svg {
            width: 18px;
            height: 18px;
            fill: #f44336;
        }

        .print-cell-button {
            background-color: transparent;
            border: none;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .print-cell-button:hover {
            background-color: rgba(66, 75, 152, 0.1);
        }

        .print-cell-button svg {
            width: 16px;
            height: 16px;
            fill: #424b98;
        }

        .dark .print-cell-button svg {
            fill: #e0c91b;
        }

        .print-tickets-button {
            margin-top: 15px;
        }

        .tab-cell-actions {
            display: flex;
            gap: 5px;
            margin-top: 5px;
            justify-content: center;
        }

        .duplicate-button {
            background-color: #17a2b8;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            padding: 4px 8px;
            font-size: 0.7rem;
            transition: all 0.3s ease;
        }

        .duplicate-button:hover {
            background-color: #138496;
            transform: translateY(-1px);
        }

        .duplicate-button svg {
            width: 12px;
            height: 12px;
        }

        /* Estilos para la lista de mejores apostadores */
        .top-gamblers-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            width: fit-content%;
        }

        .dark .top-gamblers-container {
            background-color: #161615;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        .top-gamblers-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #1b1b18;
            text-align: center;
        }

        .dark .top-gamblers-title {
            color: #EDEDEC;
        }

        .top-gamblers-list {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .gambler-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            width: 200px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 2px solid #424b98;
        }

        .dark .gambler-card {
            background-color: #2a2a2a;
            border-color: #e0c91b;
        }

        .gambler-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .dark .gambler-card:hover {
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
        }

        .gambler-position {
            font-size: 1.5rem;
            font-weight: 600;
            color: #424b98;
            margin-bottom: 10px;
        }

        .dark .gambler-position {
            color: #e0c91b;
        }

        .gambler-name {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 5px;
            color: #1b1b18;
        }

        .dark .gambler-name {
            color: #EDEDEC;
        }

        .gambler-points {
            font-size: 1rem;
            color: #666;
            font-weight: 600;
        }

        .dark .gambler-points {
            color: #aaa;
        }

        .no-gamblers {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }

        .dark .no-gamblers {
            color: #aaa;
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
        <!-- Información del Remate -->
        <div class="form-container">
            <div class="auction-info">
                <div class="auction-name">{{ $auction->name }}</div>
                <div class="auction-details">
                    <div class="detail-item">
                        <span class="detail-label">Total General</span>
                        <span class="detail-value">VES.{{ number_format($auction->total, 2) }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Ganancia Total Casa</span>
                        <span class="detail-value">VES.{{ number_format($auction->earnings_to_home, 2) }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Ganancia Total Ganadores</span>
                        <span class="detail-value">VES.{{ number_format($auction->earnings_to_winner, 2) }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Pote adicional</span>
                        <span class="detail-value">VES.{{ number_format($auction->additional_pot, 2) }}</span>
                    </div>

                </div>
            </div>
        </div>
        <div class="top-gamblers-container">
            <h2 class="top-gamblers-title">Top 3 Apostadores</h2>
            <div class="top-gamblers-list">
                @if ($gamblers->count() > 0)
                    @foreach ($gamblers as $index => $gambler)
                        <div class="gambler-card">
                            <div class="gambler-position">{{ $index + 1 }}º</div>
                            <div class="gambler-name">{{ $gambler->name }}</div>
                            <div class="gambler-points">{{ $gambler->points }} puntos</div>
                        </div>
                    @endforeach
                @else
                    <div class="no-gamblers">
                        <p>No hay apostadores registrados aún</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tabla de Carreras -->
        <div class="tab-container">
            <div class="tab-header">
                <h2 class="tab-title">Carreras</h2>
                <button id="update-tab-button" class="update-tab-button hidden">Actualizar Tablilla</button>
            </div>

            <div class="bets-table-container">
                <table class="bets-table">
                    <thead>
                        <tr>
                            <th class="horse-number-cell">#</th>
                            <th class="horse-name-cell">Caballo</th>
                            <th class="tab-column tab-header-cell">Tab 1</th>
                            <th class="tab-column tab-header-cell">Tab 2</th>
                            <th class="tab-column tab-header-cell">Tab 3</th>
                            <th class="tab-column tab-header-cell">Tab 4</th>
                            <th class="tab-column tab-header-cell">Tab 5</th>
                            <th>Ganador</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="bets-table-body">
                        <!-- Las filas se generarán dinámicamente con JavaScript -->
                    </tbody>
                </table>
                <button type="button" class="add-horse-button" id="add-horse-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Agregar Caballo
                </button>
            </div>

            <!-- Cálculos por Tab - Rediseñado -->
            <div class="calculations-section">
                <div class="calculation-card">
                    <div class="calculation-card-title">Tab 1</div>
                    <div class="calculation-details">
                        <div class="calculation-row">
                            <span class="calculation-label">Pote:</span>
                            <span class="calculation-value" id="pote-tab1">$0.00</span>
                        </div>
                        <div class="calculation-row">
                            <span class="calculation-label">Ganador (70%):</span>
                            <span class="calculation-value" id="ganador-tab1">$0.00</span>
                        </div>
                        <div class="calculation-row">
                            <span class="calculation-label">Casa (30%):</span>
                            <span class="calculation-value" id="casa-tab1">$0.00</span>
                        </div>
                    </div>
                </div>
                <div class="calculation-card">
                    <div class="calculation-card-title">Tab 2</div>
                    <div class="calculation-details">
                        <div class="calculation-row">
                            <span class="calculation-label">Pote:</span>
                            <span class="calculation-value" id="pote-tab2">$0.00</span>
                        </div>
                        <div class="calculation-row">
                            <span class="calculation-label">Ganador (70%):</span>
                            <span class="calculation-value" id="ganador-tab2">$0.00</span>
                        </div>
                        <div class="calculation-row">
                            <span class="calculation-label">Casa (30%):</span>
                            <span class="calculation-value" id="casa-tab2">$0.00</span>
                        </div>
                    </div>
                </div>
                <div class="calculation-card">
                    <div class="calculation-card-title">Tab 3</div>
                    <div class="calculation-details">
                        <div class="calculation-row">
                            <span class="calculation-label">Pote:</span>
                            <span class="calculation-value" id="pote-tab3">$0.00</span>
                        </div>
                        <div class="calculation-row">
                            <span class="calculation-label">Ganador (70%):</span>
                            <span class="calculation-value" id="ganador-tab3">$0.00</span>
                        </div>
                        <div class="calculation-row">
                            <span class="calculation-label">Casa (30%):</span>
                            <span class="calculation-value" id="casa-tab3">$0.00</span>
                        </div>
                    </div>
                </div>
                <div class="calculation-card">
                    <div class="calculation-card-title">Tab 4</div>
                    <div class="calculation-details">
                        <div class="calculation-row">
                            <span class="calculation-label">Pote:</span>
                            <span class="calculation-value" id="pote-tab4">$0.00</span>
                        </div>
                        <div class="calculation-row">
                            <span class="calculation-label">Ganador (70%):</span>
                            <span class="calculation-value" id="ganador-tab4">$0.00</span>
                        </div>
                        <div class="calculation-row">
                            <span class="calculation-label">Casa (30%):</span>
                            <span class="calculation-value" id="casa-tab4">$0.00</span>
                        </div>
                    </div>
                </div>
                <div class="calculation-card">
                    <div class="calculation-card-title">Tab 5</div>
                    <div class="calculation-details">
                        <div class="calculation-row">
                            <span class="calculation-label">Pote:</span>
                            <span class="calculation-value" id="pote-tab5">$0.00</span>
                        </div>
                        <div class="calculation-row">
                            <span class="calculation-label">Ganador (70%):</span>
                            <span class="calculation-value" id="ganador-tab5">$0.00</span>
                        </div>
                        <div class="calculation-row">
                            <span class="calculation-label">Casa (30%):</span>
                            <span class="calculation-value" id="casa-tab5">$0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <button id="print-all-tickets" class="print-tickets-button">
                <svg class="print-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z" />
                </svg>
                Imprimir Todos los Tickets
            </button>
        </div>

        <!-- Botones de acción -->
        <div class="form-actions">
            <a href="{{ route('auctions.index') }}" class="cancel-button">Volver</a>
        </div>
    </div>

    <script>
        // Nueva estructura de datos simplificada
        let auctionData = {
            caballos: [], // Array de objetos {id, numero, nombre, tab1: {apostador, monto}, tab2: {...}, ...}
            earnings: {
                total_bet: 0,
                total_house: 0,
                total_winner: 0,
                tab1: {
                    bet: 0,
                    house: 0,
                    winner: 0
                },
                tab2: {
                    bet: 0,
                    house: 0,
                    winner: 0
                },
                tab3: {
                    bet: 0,
                    house: 0,
                    winner: 0
                },
                tab4: {
                    bet: 0,
                    house: 0,
                    winner: 0
                },
                tab5: {
                    bet: 0,
                    house: 0,
                    winner: 0
                }
            }
        };

        let hasChanges = false;

        // Cargar datos iniciales desde auction->data
        @if ($auction->data)
            loadDataFromAuctionData(@json($auction->data));
        @endif

        function loadDataFromAuctionData(auctionDataFromServer) {
            if (auctionDataFromServer && auctionDataFromServer.caballos) {
                // Usar directamente los datos del servidor
                auctionData.caballos = auctionDataFromServer.caballos;
                auctionData.earnings = auctionDataFromServer.earnings || auctionData.earnings;
            }
        }

        // Función para obtener el siguiente número disponible (siempre el más alto + 1)
        function getNextHorseNumber() {
            if (auctionData.caballos.length === 0) {
                return 1;
            }

            // Obtener todos los números de caballo existentes
            const existingNumbers = auctionData.caballos.map(horse => horse.numero);

            // Encontrar el número más alto y sumar 1
            const maxNumber = Math.max(...existingNumbers);
            return maxNumber + 1;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const updateTabButton = document.getElementById('update-tab-button');
            const addHorseButton = document.getElementById('add-horse-button');
            const printAllTicketsButton = document.getElementById('print-all-tickets');

            // Añadir caballo
            addHorseButton.addEventListener('click', function() {
                addHorse();
            });

            // Botón de actualizar tablilla
            updateTabButton.addEventListener('click', function() {
                sendUpdate();
            });

            // Imprimir todos los tickets
            printAllTicketsButton.addEventListener('click', function() {
                printAllTickets();
            });

            // Cargar contenido inicial
            loadTableContent();
        });

        function loadTableContent() {
            const tableBody = document.getElementById('bets-table-body');
            tableBody.innerHTML = '';

            // Crear filas para cada caballo
            auctionData.caballos.forEach((horse, index) => {
                addHorseRow(horse, index);
            });

            updateCalculations();
            toggleUpdateButton();
        }

        function addHorseRow(horse, index) {
            const tableBody = document.getElementById('bets-table-body');

            const row = document.createElement('tr');
            row.dataset.horseId = horse.id;
            row.innerHTML = `
                <td class="horse-number-cell">${horse.numero}</td>
                <td class="horse-name-cell">
                    <input type="text" class="bet-input horse-name-input" value="${horse.nombre}" placeholder="Caballo" data-horse-id="${horse.id}">
                </td>
                <td class="tab-column">
                    <input type="text" class="bet-input bet-person" value="${horse.tab1.apostador}" placeholder="Apostador" data-tab="1" data-horse-id="${horse.id}">
                    <input type="number" class="bet-input bet-amount-input" value="${horse.tab1.monto}" placeholder="Monto" min="0" step="0.01" data-tab="1" data-horse-id="${horse.id}">
                    <div class="tab-cell-actions">
                        <button class="print-cell-button" data-tab="1" data-horse-id="${horse.id}">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                            </svg>
                        </button>
                        <button class="duplicate-button" data-tab="1" data-horse-id="${horse.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </button>
                    </div>
                </td>
                <td class="tab-column">
                    <input type="text" class="bet-input bet-person" value="${horse.tab2.apostador}" placeholder="Apostador" data-tab="2" data-horse-id="${horse.id}">
                    <input type="number" class="bet-input bet-amount-input" value="${horse.tab2.monto}" placeholder="Monto" min="0" step="0.01" data-tab="2" data-horse-id="${horse.id}">
                    <div class="tab-cell-actions">
                        <button class="print-cell-button" data-tab="2" data-horse-id="${horse.id}">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                            </svg>
                        </button>
                        <button class="duplicate-button" data-tab="2" data-horse-id="${horse.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </button>
                    </div>
                </td>
                <td class="tab-column">
                    <input type="text" class="bet-input bet-person" value="${horse.tab3.apostador}" placeholder="Apostador" data-tab="3" data-horse-id="${horse.id}">
                    <input type="number" class="bet-input bet-amount-input" value="${horse.tab3.monto}" placeholder="Monto" min="0" step="0.01" data-tab="3" data-horse-id="${horse.id}">
                    <div class="tab-cell-actions">
                        <button class="print-cell-button" data-tab="3" data-horse-id="${horse.id}">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                            </svg>
                        </button>
                        <button class="duplicate-button" data-tab="3" data-horse-id="${horse.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </button>
                    </div>
                </td>
                <td class="tab-column">
                    <input type="text" class="bet-input bet-person" value="${horse.tab4.apostador}" placeholder="Apostador" data-tab="4" data-horse-id="${horse.id}">
                    <input type="number" class="bet-input bet-amount-input" value="${horse.tab4.monto}" placeholder="Monto" min="0" step="0.01" data-tab="4" data-horse-id="${horse.id}">
                    <div class="tab-cell-actions">
                        <button class="print-cell-button" data-tab="4" data-horse-id="${horse.id}">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                            </svg>
                        </button>
                        <button class="duplicate-button" data-tab="4" data-horse-id="${horse.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </button>
                    </div>
                </td>
                <td class="tab-column">
                    <input type="text" class="bet-input bet-person" value="${horse.tab5.apostador}" placeholder="Apostador" data-tab="5" data-horse-id="${horse.id}">
                    <input type="number" class="bet-input bet-amount-input" value="${horse.tab5.monto}" placeholder="Monto" min="0" step="0.01" data-tab="5" data-horse-id="${horse.id}">
                    <div class="tab-cell-actions">
                        <button class="print-cell-button" data-tab="5" data-horse-id="${horse.id}">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                            </svg>
                        </button>
                        <button class="duplicate-button" data-tab="5" data-horse-id="${horse.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </button>
                    </div>
                </td>
                <td>
                    <input type="checkbox" class="winner-checkbox" ${horse.ganador ? 'checked' : ''} data-horse-id="${horse.id}">
                </td>
                <td>
                    <button type="button" class="delete-horse-button" data-horse-id="${horse.id}">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                        </svg>
                    </button>
                </td>
            `;

            tableBody.appendChild(row);

            // Añadir event listeners
            const horseNameInput = row.querySelector('.horse-name-input');
            horseNameInput.addEventListener('input', function() {
                updateHorseName(this.dataset.horseId, this.value);
            });

            const betPersonInputs = row.querySelectorAll('.bet-person');
            betPersonInputs.forEach(input => {
                input.addEventListener('input', function() {
                    updateBetPerson(this.dataset.horseId, this.dataset.tab, this.value);
                });
            });

            const betAmountInputs = row.querySelectorAll('.bet-amount-input');
            betAmountInputs.forEach(input => {
                input.addEventListener('input', function() {
                    updateBetAmount(this.dataset.horseId, this.dataset.tab, parseFloat(this.value) || 0);
                });
            });

            const winnerCheckbox = row.querySelector('.winner-checkbox');
            winnerCheckbox.addEventListener('change', function() {
                updateWinner(this.dataset.horseId, this.checked);
            });

            const deleteButton = row.querySelector('.delete-horse-button');
            deleteButton.addEventListener('click', function() {
                deleteHorse(this.dataset.horseId);
            });

            const printButtons = row.querySelectorAll('.print-cell-button');
            printButtons.forEach(button => {
                button.addEventListener('click', function() {
                    printTicket(this.dataset.horseId, this.dataset.tab);
                });
            });

            const duplicateButtons = row.querySelectorAll('.duplicate-button');
            duplicateButtons.forEach(button => {
                button.addEventListener('click', function() {
                    duplicateFromPreviousTab(this.dataset.horseId, this.dataset.tab);
                });
            });
        }

        function addHorse() {
            const newId = auctionData.caballos.length > 0 ? Math.max(...auctionData.caballos.map(h => h.id)) + 1 : 1;
            const newHorse = {
                id: newId,
                numero: getNextHorseNumber(), // Asignar número automáticamente
                nombre: '',
                tab1: {
                    apostador: '',
                    monto: 0
                },
                tab2: {
                    apostador: '',
                    monto: 0
                },
                tab3: {
                    apostador: '',
                    monto: 0
                },
                tab4: {
                    apostador: '',
                    monto: 0
                },
                tab5: {
                    apostador: '',
                    monto: 0
                },
                ganador: false
            };
            auctionData.caballos.push(newHorse);
            addHorseRow(newHorse, auctionData.caballos.length - 1);
            hasChanges = true;
            toggleUpdateButton();
        }

        function updateHorseName(horseId, nombre) {
            const horse = auctionData.caballos.find(h => h.id == horseId);
            if (horse) {
                horse.nombre = nombre;
            }
            hasChanges = true;
            toggleUpdateButton();
        }

        function updateBetPerson(horseId, tab, apostador) {
            const horse = auctionData.caballos.find(h => h.id == horseId);
            if (horse) {
                horse[`tab${tab}`].apostador = apostador;
            }
            hasChanges = true;
            toggleUpdateButton();
            updateCalculations();
        }

        function updateBetAmount(horseId, tab, monto) {
            const horse = auctionData.caballos.find(h => h.id == horseId);
            if (horse) {
                horse[`tab${tab}`].monto = monto;
            }
            hasChanges = true;
            toggleUpdateButton();
            updateCalculations();
        }

        function updateWinner(horseId, ganador) {
            // Solo un caballo puede ser ganador
            auctionData.caballos.forEach(horse => {
                horse.ganador = (horse.id == horseId && ganador);
            });

            // Actualizar checkboxes en la tabla
            const checkboxes = document.querySelectorAll('.winner-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = (checkbox.dataset.horseId == horseId && ganador);
            });

            hasChanges = true;
            toggleUpdateButton();
        }

        function duplicateFromPreviousTab(horseId, currentTab) {
            const currentTabNum = parseInt(currentTab);
            if (currentTabNum <= 1) {
                alert('No hay tab anterior para duplicar.');
                return;
            }

            const horse = auctionData.caballos.find(h => h.id == horseId);
            const prevTabKey = `tab${currentTabNum - 1}`;
            const currentTabKey = `tab${currentTabNum}`;

            if (horse && horse[prevTabKey]) {
                // Duplicar datos
                horse[currentTabKey].apostador = horse[prevTabKey].apostador;
                horse[currentTabKey].monto = horse[prevTabKey].monto;

                // Actualizar la interfaz
                const row = document.querySelector(`tr[data-horse-id="${horseId}"]`);
                const personInput = row.querySelector(`.bet-person[data-tab="${currentTabNum}"]`);
                const amountInput = row.querySelector(`.bet-amount-input[data-tab="${currentTabNum}"]`);

                if (personInput) personInput.value = horse[prevTabKey].apostador;
                if (amountInput) amountInput.value = horse[prevTabKey].monto;

                hasChanges = true;
                toggleUpdateButton();
                updateCalculations();
            } else {
                alert('No hay datos en la tab anterior para duplicar.');
            }
        }

        function deleteHorse(horseId) {
            if (confirm('¿Estás seguro de que quieres eliminar este caballo y todas sus apuestas?')) {
                // Eliminar el caballo sin reordenar los números
                auctionData.caballos = auctionData.caballos.filter(h => h.id != horseId);
                loadTableContent();
                hasChanges = true;
                toggleUpdateButton();
            }
        }

        function updateCalculations() {
            // Calcular totales por tab
            for (let i = 1; i <= 5; i++) {
                const tabKey = `tab${i}`;
                const total = auctionData.caballos.reduce((sum, horse) => sum + (horse[tabKey].monto || 0), 0);

                const ganador = total * 0.7;
                const casa = total * 0.3;

                auctionData.earnings[tabKey].bet = total;
                auctionData.earnings[tabKey].house = casa;
                auctionData.earnings[tabKey].winner = ganador;

                // Actualizar la interfaz
                document.getElementById(`pote-tab${i}`).textContent = `VES.${total.toFixed(2)}`;
                document.getElementById(`ganador-tab${i}`).textContent = `VES.${ganador.toFixed(2)}`;
                document.getElementById(`casa-tab${i}`).textContent = `VES.${casa.toFixed(2)}`;
            }

            // Calcular totales generales
            auctionData.earnings.total_bet = Object.values(auctionData.earnings).reduce((sum, tab) =>
                sum + (tab.bet || 0), 0);
            auctionData.earnings.total_house = auctionData.earnings.total_bet * 0.3;
            auctionData.earnings.total_winner = auctionData.earnings.total_bet * 0.7;
        }

        function toggleUpdateButton() {
            const updateTabButton = document.getElementById('update-tab-button');
            updateTabButton.classList.toggle('hidden', !hasChanges);
        }

        function sendUpdate() {
            // Enviar directamente la nueva estructura de datos
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('auction_data', JSON.stringify(auctionData));
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route('auctions.update', $auction->id) }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        hasChanges = false;
                        toggleUpdateButton();
                        alert('Datos actualizados exitosamente.');
                    } else {
                        alert('Error al actualizar: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al actualizar.');
                });
        }

        function printTicket(horseId, tab) {
            const horse = auctionData.caballos.find(h => h.id == horseId);
            const tabData = horse[`tab${tab}`];

            if (!tabData.apostador) {
                alert('Por favor, ingrese el nombre del apostador antes de generar el ticket.');
                return;
            }

            const button = event.target.closest('button');
            button.classList.add('loading');

            fetch(`/auction/{{ $auction->id }}/generate-ticket`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        person: tabData.apostador,
                        horse: horse.nombre,
                        amount: tabData.monto,
                        tab: tab
                    })
                })
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = `ticket-tab${tab}-${tabData.apostador}.pdf`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    window.URL.revokeObjectURL(url);

                    button.classList.remove('loading');
                })
                .catch(error => {
                    console.error('Error:', error);
                    button.classList.remove('loading');
                });
        }

        function printAllTickets() {
            const button = document.getElementById('print-all-tickets');
            button.classList.add('loading');
            button.disabled = true;

            fetch(`/auction/{{ $auction->id }}/print-all-tickets`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.blob();
                })
                .then(blob => {
                    if (blob.size === 0) {
                        throw new Error('El PDF está vacío');
                    }

                    const url = window.URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = `todos-tickets-{{ $auction->name }}.pdf`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    window.URL.revokeObjectURL(url);

                    button.classList.remove('loading');
                    button.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al generar el PDF: ' + error.message);
                    button.classList.remove('loading');
                    button.disabled = false;
                });
        }

        // Permitir impresión con Ctrl+P
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                printAllTickets();
            }
        });
    </script>
</body>

</html>
