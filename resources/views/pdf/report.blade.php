<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Remates</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #424b98;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #424b98;
            margin: 0;
            font-size: 24px;
        }

        .header .subtitle {
            color: #666;
            font-size: 14px;
        }

        .summary {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #424b98;
        }

        .summary h2 {
            color: #424b98;
            margin-top: 0;
            font-size: 18px;
        }

        .totals-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .total-item {
            padding: 15px;
            background: white;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
        }

        .total-item.important {
            background-color: #424b98;
            color: white;
            border: none;
        }

        .total-label {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .total-value {
            font-size: 18px;
            font-weight: bold;
        }

        .auctions-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .auctions-table th {
            background-color: #424b98;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 12px;
        }

        .auctions-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 12px;
        }

        .auctions-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            font-size: 11px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>REPORTE DE REMATES - HERMANOS GARCIA</h1>
        <div class="subtitle">Generado el: {{ $report_date }}</div>
    </div>

    <div class="summary">
        <h2>RESUMEN GENERAL</h2>
        <div class="totals-grid">
            <div class="total-item">
                <div class="total-label">Total Remates Activos</div>
                <div class="total-value">{{ $total_auctions }}</div>
            </div>
            <div class="total-item important">
                <div class="total-label">Ganancia Total Casa</div>
                <div class="total-value">VES. {{ number_format($total_earnings_to_home, 2) }}</div>
            </div>
            <div class="total-item">
                <div class="total-label">Ganancia Total Ganadores</div>
                <div class="total-value">VES. {{ number_format($total_earnings_to_winner, 2) }}</div>
            </div>
            <div class="total-item">
                <div class="total-label">Pote Adicional Total</div>
                <div class="total-value">VES. {{ number_format($total_additional_pot, 2) }}</div>
            </div>
            <div class="total-item important">
                <div class="total-label">Ganancia Ganadores + Pote</div>
                <div class="total-value">VES. {{ number_format($total_earnings_to_winner_with_pot, 2) }}</div>
            </div>
            <div class="total-item important">
                <div class="total-label">Total General Apostado</div>
                <div class="total-value">VES. {{ number_format($total_general, 2) }}</div>
            </div>
        </div>
    </div>

    @if ($auctions->count() > 0)
        <h2>DETALLE POR REMATE</h2>
        <table class="auctions-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th class="text-right">Total Apostado</th>
                    <th class="text-right">Ganancia Casa</th>
                    <th class="text-right">Ganancia Ganadores</th>
                    <th class="text-right">Pote Adicional</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($auctions as $auction)
                    <tr>
                        <td>{{ $auction->id }}</td>
                        <td>{{ $auction->name }}</td>
                        <td class="text-right">VES. {{ number_format($auction->total, 2) }}</td>
                        <td class="text-right">VES. {{ number_format($auction->earnings_to_home, 2) }}</td>
                        <td class="text-right">VES. {{ number_format($auction->earnings_to_winner, 2) }}</td>
                        <td class="text-right">VES. {{ number_format($auction->additional_pot, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center" style="padding: 40px; color: #666;">
            No hay remates activos para generar el reporte.
        </div>
    @endif

    <div class="footer">
        Sistema de Remates Hermanos García - {{ date('Y') }}
    </div>
</body>

</html>
