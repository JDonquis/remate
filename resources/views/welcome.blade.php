<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
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

        .create-button {
            background-color: #424b98;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .create-button:hover {
            background-color: #e0c91b;
        }

        .close-auction-button {
            background-color: #e0911b;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .close-auction-button:hover {
            background-color: #424b98;
        }

        .main-content {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            flex-grow: 1;
        }

        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
            padding: 20px;
            margin-bottom: 20px;
        }

        .dark .table-container {
            background-color: #161615;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e3e3e0;
        }

        .dark th,
        .dark td {
            border-bottom: 1px solid #3E3E3A;
        }

        th {
            background-color: #f9f9f9;
            font-weight: 600;
        }

        .dark th {
            background-color: #2a2a2a;
        }

        .action-buttons a {
            margin-right: 10px;
            text-decoration: none;
            color: #424b98;
        }

        .action-buttons a:hover {
            color: #e0c91b;
        }

        .action-buttons svg {
            width: 20px;
            height: 20px;
            vertical-align: middle;
        }

        .logo {
            width: 70px;
            height: 70px;
            background-position: center;
            background-size: cover;
            border-radius: 50%;
            background-image: url({{ asset('icon.png') }});
        }

        /* Estilos para el formulario de eliminación */
        .delete-form {
            display: inline-block;
        }

        .delete-button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            color: #424b98;
        }

        .delete-button:hover {
            color: #e0c91b;
        }

        /* Estilos para la paginación */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .pagination-info {
            margin: 0 15px;
            color: #666;
            font-size: 0.9rem;
        }

        .dark .pagination-info {
            color: #aaa;
        }

        .pagination-links {
            display: flex;
            gap: 5px;
        }

        .page-link {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #424b98;
            transition: all 0.3s;
        }

        .dark .page-link {
            border-color: #444;
            color: #e0c91b;
        }

        .page-link:hover {
            background-color: #424b98;
            color: white;
            border-color: #424b98;
        }

        .dark .page-link:hover {
            background-color: #e0c91b;
            color: #1b1b18;
            border-color: #e0c91b;
        }

        .page-link.active {
            background-color: #424b98;
            color: white;
            border-color: #424b98;
        }

        .dark .page-link.active {
            background-color: #e0c91b;
            color: #1b1b18;
            border-color: #e0c91b;
        }

        .page-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .page-link.disabled:hover {
            background-color: transparent;
            color: #424b98;
            border-color: #ddd;
        }

        .dark .page-link.disabled:hover {
            color: #e0c91b;
            border-color: #444;
        }

        /* Estilos para la lista de mejores apostadores */
        .top-gamblers-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 1200px;
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
            width: 250px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .dark .gambler-card {
            background-color: #2a2a2a;
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
        }

        .gambler-points {
            font-size: 1rem;
            color: #666;
        }

        .dark .gambler-points {
            color: #aaa;
        }
    </style>
</head>

<body class="flex flex-col items-center">
    <header class="header">
        <div class="logo-container">
            <!-- Placeholder Logo SVG -->
            <div class="logo"></div>
            <span class="store-name">REMATE BODEGON MEDANOS</span>
        </div>
        <div>
            <a href="{{ route('auctions.create') }}" class="create-button">Crear Remate</a>
            <a href="{{ route('auctions.report') }}" target="_blank" class="create-button"
                style="background-color: #28a745;">Generar
                Reporte</a>

        </div>
    </header>



    <div class="main-content">
        <div class="top-gamblers-container">
            <h2 class="top-gamblers-title">Top 3 Apostadores</h2>
            <div class="top-gamblers-list">
                @php
                    $topGamblers = $gamblers->sortByDesc('points')->take(3);
                @endphp
                @foreach ($topGamblers as $index => $gambler)
                    <div class="gambler-card">
                        <div class="gambler-position">{{ $index + 1 }}º</div>
                        <div class="gambler-name">{{ $gambler->name }}</div>
                        <div class="gambler-points">{{ $gambler->points }} puntos</div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Total apostado</th>
                        <th>Ganancia a la Casa</th>
                        <th>Ganancia a Ganadores</th>
                        <th>Pote adicional</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($auctions as $auction)
                        <tr>
                            <td>{{ $auction->id }}</td>
                            <td>{{ $auction->name }}</td>
                            <td>VES.{{ number_format($auction->total, 2) }}</td>
                            <td>VES.{{ number_format($auction->earnings_to_home, 2) }}</td>
                            <td>VES.{{ number_format($auction->earnings_to_winner, 2) }}</td>
                            <td>VES.{{ number_format($auction->additional_pot, 2) }}</td>
                            <td class="action-buttons">
                                <a href="{{ route('auctions.edit', ['auction' => $auction->id]) }}" title="Ver">
                                    <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                                    </svg>
                                </a>
                                <form action="{{ route('auctions.destroy', ['auction' => $auction->id]) }}"
                                    method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button" title="Eliminar"
                                        onclick="return confirm('¿Estás seguro de que quieres eliminar este remate?')">
                                        <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if ($auctions->hasPages())
            <div class="pagination">
                <!-- Información de paginación -->
                <div class="pagination-info">
                    Mostrando {{ $auctions->firstItem() }} a {{ $auctions->lastItem() }} de {{ $auctions->total() }}
                    resultados
                </div>

                <!-- Links de paginación -->
                <div class="pagination-links">
                    <!-- Link a primera página -->
                    @if (!$auctions->onFirstPage())
                        <a href="{{ $auctions->url(1) }}" class="page-link" title="Primera página">
                            &laquo;
                        </a>
                    @else
                        <span class="page-link disabled">&laquo;</span>
                    @endif

                    <!-- Link página anterior -->
                    @if ($auctions->previousPageUrl())
                        <a href="{{ $auctions->previousPageUrl() }}" class="page-link" title="Página anterior">
                            &lsaquo;
                        </a>
                    @else
                        <span class="page-link disabled">&lsaquo;</span>
                    @endif

                    <!-- Links de páginas numeradas -->
                    @foreach ($auctions->getUrlRange(max(1, $auctions->currentPage() - 2), min($auctions->lastPage(), $auctions->currentPage() + 2)) as $page => $url)
                        @if ($page == $auctions->currentPage())
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach

                    <!-- Link página siguiente -->
                    @if ($auctions->hasMorePages())
                        <a href="{{ $auctions->nextPageUrl() }}" class="page-link" title="Página siguiente">
                            &rsaquo;
                        </a>
                    @else
                        <span class="page-link disabled">&rsaquo;</span>
                    @endif

                    <!-- Link a última página -->
                    @if ($auctions->currentPage() < $auctions->lastPage())
                        <a href="{{ $auctions->url($auctions->lastPage()) }}" class="page-link" title="Última página">
                            &raquo;
                        </a>
                    @else
                        <span class="page-link disabled">&raquo;</span>
                    @endif
                </div>
            </div>
        @endif
        <a href="{{ route('auctions.reset') }}" class="close-auction-button">Cerrar remates</a>
    </div>

</body>

</html>
