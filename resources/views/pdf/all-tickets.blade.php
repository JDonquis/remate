<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        .ticket {
            border: 2px solid #000;
            padding: 15px;
            margin: 10px;
            page-break-after: always;
        }

        .ticket:last-child {
            page-break-after: avoid;
        }

        .header {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .info {
            margin: 8px 0;
            font-size: 12px;
        }

        .horse-section {
            border: 1px solid #ccc;
            padding: 8px;
            margin: 8px 0;
            font-size: 11px;
        }

        .winner {
            background-color: #d4edda;
        }

        .all-tabs-horse {
            border: 2px solid #28a745;
            background-color: #f8fff8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
            background-color: #f8f9fa;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 10px;
            color: #666;
        }

        .pote-info {
            color: #28a745;
            font-weight: bold;
        }

        .breakdown {
            font-size: 9px;
            color: #666;
        }
    </style>
</head>

<body>
    @if (empty($tickets))
        <div class="ticket">
            <div class="header">REMATE HERMANOS GARCIA</div>
            <div class="header">{{ $auction->name }}</div>
            <div class="info" style="text-align: center;">
                <strong>No hay tickets para mostrar</strong>
            </div>
        </div>
    @else
        @foreach ($tickets as $index => $ticket)
            <div class="ticket">
                <div class="header">REMATE HERMANOS GARCIA</div>
                <div class="header">{{ $auction->name }}</div>

                <div class="info">
                    <strong>Apostador:</strong> {{ $ticket['person'] }}<br>
                    <strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }}<br>
                    <strong>Ticket #{{ $index + 1 }} de {{ count($tickets) }}</strong>
                </div>

                @if (empty($ticket['betsByHorse']))
                    <div class="info" style="text-align: center;">
                        <strong>No hay apuestas registradas</strong>
                    </div>
                @else
                    @foreach ($ticket['betsByHorse'] as $horse)
                        <div
                            class="horse-section {{ $horse['is_winner'] ? 'winner' : '' }} {{ $horse['has_all_tabs'] ? 'all-tabs-horse' : '' }}">
                            <h4 style="margin: 0 0 5px 0;">
                                {{ $horse['horse_name'] }}
                                @if ($horse['is_winner'])
                                    <span style="color: #28a745;">🏆 GANADOR</span>
                                @endif

                            </h4>

                            <table>
                                <thead>
                                    <tr>
                                        <th>Tab</th>
                                        <th>Monto Apostado</th>
                                        <th>Ganancia Potencial</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($horse['bets'] as $bet)
                                        <tr>
                                            <td>Tab {{ $bet['tab'] }}</td>
                                            <td>VES.{{ number_format($bet['amount'], 2) }}</td>
                                            <td>VES.{{ number_format($bet['potential_earnings'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="total">
                                        <td>Total {{ $horse['horse_name'] }}:</td>
                                        <td>VES.{{ number_format($horse['total_bet'], 2) }}</td>
                                        <td>
                                            @if (isset($horse['additional_pot']) && $horse['additional_pot'] > 0)
                                                <div>
                                                    <div class="breakdown">
                                                        Ganancia:
                                                        VES.{{ number_format($horse['potential_earnings'] - $horse['additional_pot'], 2) }}
                                                    </div>
                                                    <div class="pote-info">
                                                        + Bono 5 Tablas:
                                                        VES.{{ number_format($horse['additional_pot'], 2) }}
                                                    </div>
                                                    <div>
                                                        <strong>Total:
                                                            VES.{{ number_format($horse['potential_earnings'], 2) }}</strong>
                                                    </div>
                                                </div>
                                            @else
                                                VES.{{ number_format($horse['potential_earnings'], 2) }}
                                            @endif
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endforeach
                @endif

                <div class="info total" style="border-top: 2px solid #000; padding-top: 8px;">
                    <strong>Total Apostado:</strong> VES.{{ number_format($ticket['totalBet'], 2) }}<br>
                </div>

                <div class="footer">
                    Generado el {{ now()->format('d/m/Y H:i') }}
                </div>
            </div>
        @endforeach
    @endif
</body>

</html>
