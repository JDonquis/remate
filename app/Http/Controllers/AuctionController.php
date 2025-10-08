<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Gambler;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auctions = Auction::where('status', 1)->orderBy('id', 'desc')->paginate(10);

        // Obtener los top 3 apostadores de todos los remates
        $gamblers = Gambler::orderBy('points', 'desc')
            ->limit(3)
            ->get();

        return view('welcome')->with(compact('auctions', 'gamblers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $auctions = Auction::where('status', 1)->count();

        $nextName = 'Carreras #' . ($auctions + 1);

        return view('create_auction')->with(compact('nextName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Auction::create([
            'name' => $request->name,
            'earnings_to_home' => 0,
            'earnings_to_winner' => 0,
            'total' => 0,
            'additional_pot' => $request->additional_pot,
            'status' => 1,
            'data' => null,
        ]);

        return redirect()->route('auctions.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Auction $auction)
    {
        Log::info('Datos recibidos para actualizar', $request->all());

        // Obtener los datos de la nueva estructura
        $auctionData = json_decode($request->auction_data, true);

        // Actualizar el remate con la nueva estructura de datos
        $auction->update([
            'data' => $auctionData,
            'total' => $auctionData['earnings']['total_bet'] ?? 0,
            'earnings_to_home' => $auctionData['earnings']['total_house'] ?? 0,
            'earnings_to_winner' => $auctionData['earnings']['total_winner'] ?? 0,
        ]);

        // Recalcular puntos de todos los apostadores en todos los auctions
        $this->recalculateAllGamblerPoints();

        return response()->json(['success' => true]);
    }

    /**
     * Recalculate points for all gamblers across all active auctions.
     */
    private function recalculateAllGamblerPoints()
    {
        Log::info('Iniciando recálculo de puntos para todos los apostadores');

        // Obtener todos los auctions activos
        $auctions = Auction::where('status', 1)->get();

        // Reiniciar puntos de todos los apostadores
        Gambler::query()->update(['points' => 0]);

        // Procesar cada auction
        foreach ($auctions as $auction) {
            $auctionData = $auction->data ?? [];

            if (isset($auctionData['caballos']) && is_array($auctionData['caballos'])) {
                foreach ($auctionData['caballos'] as $horse) {
                    // Procesar cada tab para este caballo
                    for ($tabNumber = 1; $tabNumber <= 5; $tabNumber++) {
                        $tabKey = 'tab' . $tabNumber;

                        if (isset($horse[$tabKey]) && !empty($horse[$tabKey]['apostador']) && $horse[$tabKey]['monto'] > 0) {
                            $apostador = $horse[$tabKey]['apostador'];

                            // Buscar o crear el apostador
                            $gambler = Gambler::where('name', $apostador)->first();

                            if (!$gambler) {
                                $gambler = Gambler::create([
                                    'name' => $apostador,
                                    'points' => 0,
                                    'earnings' => 0,
                                ]);
                            }

                            // Si este caballo es el ganador, sumar punto al apostador
                            if (isset($horse['ganador']) && $horse['ganador']) {
                                $gambler->points = $gambler->points + 1;
                                $gambler->save();
                            }
                        }
                    }
                }
            }
        }

        Log::info('Recálculo de puntos completado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Auction $auction) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auction $auction)
    {
        $gamblers = Gambler::orderBy('points', 'desc')
            ->limit(3)
            ->get();

        return view('show_auction')->with(compact('auction', 'gamblers'));
    }

    /**
     * Generate a PDF for a specific tab.
     */
    public function printTab(Request $request, Auction $auction)
    {
        $data = $request->validate([
            'horse_index' => 'required|integer',
            'tab_number' => 'required|integer',
            'horse_name' => 'required|string',
            'person' => 'required|string',
            'amount' => 'required|numeric',
            'winner_earnings' => 'required|numeric',
            'house_earnings' => 'required|numeric',
        ]);

        $pdf = Pdf::loadView('pdf.tab', [
            'auction' => $auction,
            'data' => $data
        ])->setPaper('A4', 'portrait');

        return $pdf->stream("tab-{$data['tab_number']}-{$data['horse_name']}.pdf");
    }

    /**
     * Generate a ticket for a specific gambler.
     */
    public function generateTicket(Request $request, Auction $auction)
    {
        $data = $request->validate([
            'person' => 'required|string',
        ]);

        $personName = $data['person'];

        // Usar la nueva estructura de datos
        $auctionData = $auction->data ?? [];

        $betsByHorse = [];
        $totalBet = 0;
        $totalPotentialEarnings = 0;
        $horseWithAllTabs = null;

        // Recolectar todas las apuestas de esta persona
        if (isset($auctionData['caballos']) && is_array($auctionData['caballos'])) {
            foreach ($auctionData['caballos'] as $horse) {
                $horseBets = [];
                $horseTotalBet = 0;
                $tabsApostadas = [];

                // Verificar apuestas en cada tab para este caballo
                for ($tabNumber = 1; $tabNumber <= 5; $tabNumber++) {
                    $tabKey = 'tab' . $tabNumber;

                    if (isset($horse[$tabKey]) && $horse[$tabKey]['apostador'] === $personName && $horse[$tabKey]['monto'] > 0) {
                        // Calcular ganancia potencial
                        $potentialEarnings = $auctionData['earnings'][$tabKey]['winner'] ?? 0;

                        $horseBets[] = [
                            'tab' => $tabNumber,
                            'amount' => $horse[$tabKey]['monto'],
                            'potential_earnings' => $potentialEarnings
                        ];
                        $horseTotalBet += $horse[$tabKey]['monto'];
                        $tabsApostadas[] = $tabNumber;
                    }
                }

                // Si tiene apuestas en este caballo, agregarlo
                if (!empty($horseBets)) {
                    // Calcular ganancia potencial total para este caballo
                    $horsePotentialEarnings = array_sum(array_column($horseBets, 'potential_earnings'));

                    $horseData = [
                        'horse_name' => $horse['nombre'] ?? 'Caballo ' . $horse['id'],
                        'bets' => $horseBets,
                        'total_bet' => $horseTotalBet,
                        'potential_earnings' => $horsePotentialEarnings,
                        'is_winner' => $horse['ganador'] ?? false,
                        'has_all_tabs' => count($tabsApostadas) === 5 // Verificar si apostó en las 5 tablas para este caballo
                    ];

                    // Si este caballo tiene las 5 tablas, guardar referencia
                    if ($horseData['has_all_tabs']) {
                        $horseWithAllTabs = $horseData['horse_name'];
                    }

                    $betsByHorse[] = $horseData;
                    $totalBet += $horseTotalBet;
                    $totalPotentialEarnings += $horsePotentialEarnings;
                }
            }
        }

        // Aplicar pote adicional SOLO al caballo donde apostó en las 5 tablas
        $potentialAdditionalPot = 0;

        if ($horseWithAllTabs && $auction->additional_pot > 0) {
            $potentialAdditionalPot = $auction->additional_pot;
            $totalPotentialEarnings += $potentialAdditionalPot;

            // Agregar el pote adicional SOLO al caballo que tiene las 5 tablas
            foreach ($betsByHorse as $index => $horseData) {
                if ($horseData['horse_name'] === $horseWithAllTabs) {
                    $betsByHorse[$index]['potential_earnings'] += $potentialAdditionalPot;
                    $betsByHorse[$index]['additional_pot'] = $potentialAdditionalPot;
                    break;
                }
            }
        }

        $pdf = Pdf::loadView('pdf.ticket', [
            'auction' => $auction,
            'person' => $personName,
            'betsByHorse' => $betsByHorse,
            'totalBet' => $totalBet,
            'totalPotentialEarnings' => $totalPotentialEarnings,
            'potentialAdditionalPot' => $potentialAdditionalPot,
            'horseWithAllTabs' => $horseWithAllTabs
        ])->setPaper('A4', 'portrait');

        return $pdf->stream("ticket-{$personName}.pdf");
    }

    /**
     * Generate tickets for all gamblers in the auction.
     */
    public function printAllTickets(Request $request, Auction $auction)
    {
        Log::info('Iniciando generación de todos los tickets para auction: ' . $auction->id);

        // Usar la nueva estructura de datos
        $auctionData = $auction->data ?? [];

        Log::info('Datos del auction:', $auctionData);

        $allGamblersTickets = [];

        // Recolectar todos los apostadores únicos
        $gamblers = [];
        if (isset($auctionData['caballos']) && is_array($auctionData['caballos'])) {
            foreach ($auctionData['caballos'] as $horse) {
                for ($tabNumber = 1; $tabNumber <= 5; $tabNumber++) {
                    $tabKey = 'tab' . $tabNumber;
                    if (isset($horse[$tabKey]) && !empty($horse[$tabKey]['apostador']) && $horse[$tabKey]['monto'] > 0) {
                        $gamblerName = $horse[$tabKey]['apostador'];
                        if (!in_array($gamblerName, $gamblers)) {
                            $gamblers[] = $gamblerName;
                        }
                    }
                }
            }
        }

        Log::info('Apostadores encontrados:', $gamblers);

        // Si no hay apostadores, retornar un PDF vacío con mensaje
        if (empty($gamblers)) {
            Log::info('No se encontraron apostadores');
            $pdf = Pdf::loadView('pdf.no-tickets', [
                'auction' => $auction
            ])->setPaper('A4', 'portrait');

            return $pdf->stream("todos-tickets-{$auction->name}.pdf");
        }

        // Generar datos de ticket para cada apostador
        foreach ($gamblers as $gamblerName) {
            Log::info('Procesando apostador: ' . $gamblerName);

            $betsByHorse = [];
            $totalBet = 0;
            $totalPotentialEarnings = 0;
            $horseWithAllTabs = null;

            // Recolectar apuestas de este apostador
            foreach ($auctionData['caballos'] as $horse) {
                $horseBets = [];
                $horseTotalBet = 0;
                $tabsApostadas = [];

                for ($tabNumber = 1; $tabNumber <= 5; $tabNumber++) {
                    $tabKey = 'tab' . $tabNumber;

                    if (isset($horse[$tabKey]) && $horse[$tabKey]['apostador'] === $gamblerName && $horse[$tabKey]['monto'] > 0) {
                        // Calcular ganancia potencial
                        $potentialEarnings = $auctionData['earnings'][$tabKey]['winner'] ?? 0;

                        $horseBets[] = [
                            'tab' => $tabNumber,
                            'amount' => $horse[$tabKey]['monto'],
                            'potential_earnings' => $potentialEarnings
                        ];
                        $horseTotalBet += $horse[$tabKey]['monto'];
                        $tabsApostadas[] = $tabNumber;
                    }
                }

                if (!empty($horseBets)) {
                    // Calcular ganancia potencial total para este caballo
                    $horsePotentialEarnings = array_sum(array_column($horseBets, 'potential_earnings'));

                    $horseData = [
                        'horse_name' => $horse['nombre'] ?? 'Caballo ' . $horse['id'],
                        'bets' => $horseBets,
                        'total_bet' => $horseTotalBet,
                        'potential_earnings' => $horsePotentialEarnings,
                        'is_winner' => $horse['ganador'] ?? false,
                        'has_all_tabs' => count($tabsApostadas) === 5 // Verificar si apostó en las 5 tablas para este caballo
                    ];

                    // Si este caballo tiene las 5 tablas, guardar referencia
                    if ($horseData['has_all_tabs']) {
                        $horseWithAllTabs = $horseData['horse_name'];
                    }

                    $betsByHorse[] = $horseData;
                    $totalBet += $horseTotalBet;
                    $totalPotentialEarnings += $horsePotentialEarnings;
                }
            }

            // Aplicar pote adicional SOLO al caballo donde apostó en las 5 tablas
            $potentialAdditionalPot = 0;

            if ($horseWithAllTabs && $auction->additional_pot > 0) {
                $potentialAdditionalPot = $auction->additional_pot;
                $totalPotentialEarnings += $potentialAdditionalPot;

                // Agregar el pote adicional SOLO al caballo que tiene las 5 tablas
                foreach ($betsByHorse as $index => $horseData) {
                    if ($horseData['horse_name'] === $horseWithAllTabs) {
                        $betsByHorse[$index]['potential_earnings'] += $potentialAdditionalPot;
                        $betsByHorse[$index]['additional_pot'] = $potentialAdditionalPot;
                        break;
                    }
                }
            }

            $allGamblersTickets[] = [
                'person' => $gamblerName,
                'betsByHorse' => $betsByHorse,
                'totalBet' => $totalBet,
                'totalPotentialEarnings' => $totalPotentialEarnings,
                'potentialAdditionalPot' => $potentialAdditionalPot,
                'horseWithAllTabs' => $horseWithAllTabs
            ];
        }

        Log::info('Tickets generados:', ['count' => count($allGamblersTickets)]);

        try {
            $pdf = Pdf::loadView('pdf.all-tickets', [
                'auction' => $auction,
                'tickets' => $allGamblersTickets
            ])->setPaper('A4', 'portrait');

            Log::info('PDF generado exitosamente');

            return $pdf->stream("todos-tickets-{$auction->name}.pdf");
        } catch (\Exception $e) {
            Log::error('Error al generar PDF: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());

            return response()->json(['error' => 'Error al generar PDF: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auction $auction)
    {
        $auction->delete();

        // Recalcular puntos después de eliminar un auction
        $this->recalculateAllGamblerPoints();

        return back();
    }

    /**
     * Reset all active auctions and gamblers.
     */
    public function reset()
    {
        Auction::where('status', 1)->update(['status' => 0]);
        Gambler::query()->delete();
        return back();
    }
}
