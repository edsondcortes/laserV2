<?php

namespace App\Http\Controllers;

use App\Enums\BudgetStatus;
use App\Enums\ProductionForm;
use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\Delivery;
use App\Models\DeliveryOnTime;
use App\Models\Hotel;
use App\Models\HotelDelivery;
use App\Models\LocalDelivery;
use App\Models\SeasonDelivery;
use App\Services\Facades\Adderi;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrcamentoController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:orcamento-create', ['only' => ['index', 'search', 'delivery', 'store']]);
        $this->middleware('auth');
    }

    public function index(){
        return view('orcamento.index');
    }

    public function search(Request $request){
        $numOrcamento = $request->input('orcamento');
        $numOrcamento = str_pad($numOrcamento, 10, 0, STR_PAD_LEFT);
        $numOrcamento = str_pad($numOrcamento,11, 1, STR_PAD_LEFT);
        $dadosOrcamento = Adderi::budget()->show($numOrcamento);

        if(!$dadosOrcamento->successful()){
            return redirect()->back()->with('error', 'Ouve um problema com a requisição!');
        }
        $dadosOrcamento = $dadosOrcamento->json();

        if ($dadosOrcamento['data'] == null){
            return redirect()->back()->with('error', 'Orçamento não existe!');
        }

        $hasLaserId = 0;

       foreach($dadosOrcamento['data']['orcamento_items'] as $orcamento_items){
        if($orcamento_items['grade']['produto']['caracteristica_a']['caracteristicaa'] == 10){
            $hasLaserId = 1;
            }
        }

        if($hasLaserId != 1){
            return redirect()->back()->with('error', 'Não existe produtos de Laser neste orçamento');
        }

        if($dadosOrcamento['data']['etapaorcamento'] == 90){
            return redirect()->back()->with('error', 'Orçamento está cancelado!');
        }

        $budget = Budget::where('adderi_budget', '=', $numOrcamento)
                        ->first();

        $num = $request->input('orcamento');
        $cont = 0;
        $orcamento_items = $dadosOrcamento['data']['orcamento_items'];

        $i = 0;

        foreach($orcamento_items as $key => $orcamento_item){
            $iditemorcamento = $orcamento_item['iditemorcamento'];
            $budgetItens = BudgetItem::where('adderi_budget_item', '=', $iditemorcamento)->count();
            $orcamento_items[$key]['saldo_banco'] = $orcamento_item['quantidade'] - $budgetItens;
            $i++;
        }

        $fone = 'Não Informado';

        if($dadosOrcamento['data']['customer']['0']['fones'] != []){
            foreach($dadosOrcamento['data']['customer']['0']['fones'] as $fones){
                if($fones['ativo'] == 1 && $fones['principal'] == 1){
                    $fone = $fones['fone'];
                }
            }
        }

        return view('orcamento.search', compact('num', 'dadosOrcamento','budget', 'cont', 'orcamento_items', 'fone'));
    }

    public function delivery(Request $request){
        $selectedItens = $request->all();
        $hotels = Hotel::all();

        $budgetInfos = Adderi::budget()->show($request->input('numberBudget'));
        $budgetInfos = $budgetInfos->json();

        $cont = 0;

        $selectedItem = $selectedItens['itemSelected'];
        $codigo = $selectedItens['codigo'];
        $produto = $selectedItens['produto'];

        $count = count($codigo);

        for ($i = 0; $i < $count; $i++) {
            if (isset($codigo[$i]) && isset($produto[$i]) && isset($selectedItem[$i])) {
                $code[] = $codigo[$i];
                $product[] = $produto[$i];
            }
        }

        $selectedItem = array_values($selectedItens['itemSelected']);

        $count = count($code);

        return view('orcamento.delivery', compact('hotels', 'budgetInfos', 'selectedItem', 'cont','code','product', 'count'));
    }

    public function store(Request $request){
        //dd($request->input('numberBudget'));
        $budgetInfos = Adderi::budget()->show($request->input('numberBudget'));
        $budgetInfos = $budgetInfos->json();

        foreach($budgetInfos['data']['orcamento_items'] as $key => $orcamento_item){
            $iditemorcamento = $orcamento_item['iditemorcamento'];
            $budgetItens = BudgetItem::where('adderi_budget_item', '=', $iditemorcamento)->count();
            $orcamento_items[$key]['saldo_banco'] = $orcamento_item['quantidade'] - $budgetItens;

            if($request->input('selectedItem') == $iditemorcamento && $orcamento_items[$key]['saldo_banco'] == 0){
                return redirect()->route('orcamento.index')->with('error', 'Orçamento já cadastrado!');
            }
        }

        $pos = 0;
        for($i = 0; $i <= $request->input('cont'); $i++){
            $pos = $pos + 1;
        }

        $validated = $request->validate([
            'position' => "required|array|min:{$pos}",
            'imagetype' => "required|array|min:{$pos}",
            'imageBackground' => "required|array|min:{$pos}",
            'production' => "required|array|min:{$pos}",
        ]);

        for($i = 0; $i <= $request->input('cont'); $i++){
            if($i == 0){
                $validated = $request->validate([
                    'deliveryType.'.$i => 'required',
                ]);
            }

            if($request->input('deliverySelect') == null || !array_key_exists($i, $request->input('deliverySelect'))){
                $validated = $request->validate([
                    'deliveryType.'.$i => 'required',
                ]);
            }

            if($request->input('deliverySelect') == null || !array_key_exists($i, $request->input('deliverySelect'))){
                $validated = $request->validate([
                    'hotelId.'.$i => Rule::requiredIf($request->input('deliveryType')[$i] == 'hotel'),
                    'hotelroom.'.$i => Rule::requiredIf($request->input('deliveryType')[$i] == 'hotel'),
                    'hoteldate.'.$i => Rule::requiredIf($request->input('deliveryType')[$i] == 'hotel'),
                    'hotelhour.'.$i => Rule::requiredIf($request->input('deliveryType')[$i] == 'hotel'),

                    'localdatedelivery.'.$i => Rule::requiredIf($request->input('deliveryType')[$i] == 'local'),
                    'localhourdelivery.'.$i => Rule::requiredIf($request->input('deliveryType')[$i] == 'local'),

                    'seasonstreet.'.$i => Rule::requiredIf($request->input('deliveryType')[$i] == 'temporada'),
                    'seasonnumber.'.$i => Rule::requiredIf($request->input('deliveryType')[$i] == 'temporada'),
                    'seasondistrict.'.$i => Rule::requiredIf($request->input('deliveryType')[$i] == 'temporada'),
                    'seasoncity.'.$i => Rule::requiredIf($request->input('deliveryType')[$i] == 'temporada'),
                    'seasoncomplement.'.$i => Rule::requiredIf($request->input('deliveryType')[$i] == 'temporada'),
                    'seasondatedelivery.'.$i => Rule::requiredIf($request->input('deliveryType')[$i] == 'temporada'),
                    'seasonhour.'.$i => Rule::requiredIf($request->input('deliveryType')[$i] == 'temporada'),
                    'seasondatasaida.'.$i => Rule::requiredIf($request->input('deliveryType')[$i] == 'temporada'),
                ]);
            }
        }

        $budget = Budget::where('adderi_budget', '=', $request->input('numberBudget'))->first();

        if ($budget == null) {
            $budget = Budget::create([
                'adderi_budget' => $request->input('numberBudget'),
                'status' => BudgetStatus::Edition
            ]);
        } else {
            $budget->status = BudgetStatus::Edition;
            $budget->save();
        }

        $firstDelivery = null;

        for($i = 0; $i <= $request->input('cont'); $i++){
            $budgetItem = new BudgetItem();
            $budgetItem->fill([
                'adderi_budget_item' => $request->input('selectedItem')[$i],
                'item_code' => $request->input('codigo')[$i],
                'description' => $request->input('produto')[$i],

                //'production_form' => $request->input('production')[$i],
                'position' => $request->input('position')[$i],
                'type' => $request->input('imagetype')[$i],
                'background' => $request->input('imageBackground')[$i],
                'note' => $request->input('description')[$i],
            ]);

            if($request->input('production')[$i] == 'padrao'){
                $budgetItem->production_form = ProductionForm::standard;
            }
            if($request->input('production')[$i] == 'expressa'){
                $budgetItem->production_form = ProductionForm::express;
            }
            if($request->input('production')[$i] == 'conversao'){
                $budgetItem->production_form = ProductionForm::conversion;
            }
            $budgetItem->budget_id = $budget->id;
            $budgetItem->save();

            if($i !== 0 && $request->input('deliverySelect') != null && array_key_exists($i, $request->input('deliverySelect'))){
                $deliveryIndex = 0;

                if($request->input('deliveryType')[$deliveryIndex] == 'hotel'){
                    if($firstDelivery !== null){
                        $firstDelivery->budgetItem()->save($budgetItem);
                    }
                }
                if($request->input('deliveryType')[$deliveryIndex] == 'local'){
                    if($firstDelivery !== null){
                        $firstDelivery->budgetItem()->save($budgetItem);
                    }
                }
                if($request->input('deliveryType')[$deliveryIndex] == 'temporada'){
                    if($firstDelivery !== null){
                        $firstDelivery->budgetItem()->save($budgetItem);
                    }
                }
                if($request->input('deliveryType')[$deliveryIndex] == 'despachar'){
                    if($firstDelivery !== null){
                        $firstDelivery->budgetItem()->save($budgetItem);
                    }
                }
                if($request->input('deliveryType')[$deliveryIndex] == 'deliveryOnTime'){
                    if($firstDelivery !== null){
                        $firstDelivery->budgetItem()->save($budgetItem);
                    }
                }
            }else{
                if($request->input('deliveryType')[$i] == 'hotel'){
                    $delivery = new HotelDelivery();
                    $delivery->fill([
                        'output_date_time' => Carbon::createFromFormat('d/m/Y H:i', $request->input('hoteldate')[$i].' '.$request->input('hotelhour')[$i])->format('Y-m-d H:i:s'),
                        'room' => $request->input('hotelroom')[$i],
                    ]);
                    if($request->input('hotelcheckout')[$i] != null){
                        $delivery->output_date = Carbon::createFromFormat('d/m/Y', $request->input('hotelcheckout')[$i])->format('Y-m-d');
                    } else {
                        $delivery->output_date = null;
                    }
                    $delivery->hotel_id = $request->input('hotelId')[$i];
                    $delivery->save();
                    $delivery->budgetItem()->save($budgetItem);
                }

                if($request->input('deliveryType')[$i] == 'local'){
                    $delivery = LocalDelivery::create([
                        'date_time_delivery' => Carbon::createFromFormat('d/m/Y H:i', $request->input('localdatedelivery')[$i].' '.$request->input('localhourdelivery')[$i])->format('Y-m-d H:i:s'),
                    ]);
                    if($request->input('localcheckout')[$i] != null){
                        $delivery->output_date = Carbon::createFromFormat('d/m/Y', $request->input('localcheckout')[$i])->format('Y-m-d');
                    } else {
                        $delivery->output_date = null;
                    }
                    $delivery->save();
                    $delivery->budgetItem()->save($budgetItem);
                }

                if($request->input('deliveryType')[$i] == 'temporada'){
                    $delivery = SeasonDelivery::create([
                        'street' => $request->input('seasonstreet')[$i],
                        'number' => $request->input('seasonnumber')[$i],
                        'district' => $request->input('seasondistrict')[$i],
                        'city' => $request->input('seasoncity')[$i],
                        'complement' => $request->input('seasoncomplement')[$i],
                        'delivery_date_time' => Carbon::createFromFormat('d/m/Y H:i', $request->input('seasondatedelivery')[$i].' '.$request->input('seasonhour')[$i])->format('Y-m-d H:i:s'),
                        'output_date' => Carbon::createFromFormat('d/m/Y', $request->input('seasondatasaida')[$i])->format('Y-m-d H:i:s'),
                    ]);
                    $delivery->budgetItem()->save($budgetItem);
                }

                if($request->input('deliveryType')[$i] == 'deliveryOnTime'){
                    $delivery = new DeliveryOnTime();
                    $delivery->save();
                    $delivery->budgetItem()->save($budgetItem);
                }

                if($request->input('deliveryType')[$i] == 'despachar'){
                    $delivery = new Delivery();
                    $delivery->fill([
                        'address_id' => $request->input('addressId')[$i]
                    ]);
                    $delivery->save();
                    $delivery->budgetItem()->save($budgetItem);
                }
                if($i === 0){
                    $firstDelivery = $delivery;
                }
            }
        }
        //dd($budget);
        $budgetItens = BudgetItem::where('budget_id', $budget->id)->get();

        foreach($budgetItens as $budgetItem){
            if($budgetItem['production_form'] == ProductionForm::express){
                $budgetItem->fill([
                    'cut' => Carbon::now()->format("Y-m-d H:i:s"),
                    'user_cut' => Auth::user()->id,
                    'edition' => Carbon::now()->format("Y-m-d H:i:s"),
                    'layout' => Carbon::now()->format("Y-m-d H:i:s"),
                    'engraving' => Carbon::now()->format("Y-m-d H:i:s")
                ]);
                $budgetItem->user_cut = Auth::user()->id;
                $budgetItem->user_edition = Auth::user()->id;
                $budgetItem->user_layout = Auth::user()->id;
                $budgetItem->user_engraving = Auth::user()->id;
                //dd($budgetItem);
                $budgetItem->save();
            }
            if($budgetItem['production_form'] == ProductionForm::conversion){
                $budgetItem->fill([
                    'cut' => Carbon::now()->format("Y-m-d H:i:s"),
                    'edition' => Carbon::now()->format("Y-m-d H:i:s")
                ]);
                $budgetItem->user_cut = Auth::user()->id;
                $budgetItem->user_edition = Auth::user()->id;
                $budgetItem->save();
            }
        }

        $exists = BudgetItem::where(function($query){
            $query->orWhereNull('edition')
            ->orWhereNull('cut')
            ->orWhereNull('layout');
        })->where('budget_id', $budget->id)
        ->count();

        if($exists == 0){
            $budget = Budget::find($budget->id);
            $budget->status = BudgetStatus::finished;
            $budget->save();
        }
        return redirect()->route('orcamento.index')->with('success', 'Pedido cadastrado com sucesso!');
    }
}
