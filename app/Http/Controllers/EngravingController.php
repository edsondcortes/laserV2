<?php

namespace App\Http\Controllers;

use App\Enums\BudgetStatus;
use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\Error;
use App\Models\HotelDelivery;
use App\Models\LocalDelivery;
use App\Models\SeasonDelivery;
use App\Services\Facades\Adderi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EngravingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:requests-engraving', ['only' => ['index', 'show', 'updateEngraving', 'store']]);
        $this->middleware('auth');
    }

    public function index(Request $request){
        $search = $request->input('search');

        $items = Budget::whereHas('itemBudget', function(Builder $query) {
            $query->where('status', '=', BudgetStatus::Engraving);
        })->when($search !== null, function ($query) use ($search){
            $query->where('adderi_budget', 'like', '%'.$search.'%');
        })
        ->get();

        if(count($items) != 0){
            $params = [
                'idDocumento' => $items->pluck('adderi_budget')->toArray(),
            ];
            $budgets = Adderi::budget()->index($params);
        }else{
            $budgets = null;
        }

        if($budgets != null){
            $budgets = $budgets['data'];
            foreach($budgets as $key => $budget){
                if($budget['etapaorcamento'] == 90){
                    $statusBudget = Budget::where('adderi_budget', '=', $budget['iddocumento'])->first();
                    $statusBudget->status = BudgetStatus::canceled;
                    $statusBudget->save();
                    unset($budgets[$key]);
                }
            }
        }

        foreach($items as $key => $item){
            $deliveryDate = $item->itemBudget()->whereHasMorph('delivery', [SeasonDelivery::class, LocalDelivery::class, HotelDelivery::class], function($query){
                $query->whereNotNull('output_date')
                    ->orderBy('output_date', 'asc');
             })->first();

            if($deliveryDate != null) {
                $items[$key]->checkoutDate = $deliveryDate->delivery->output_date;
            }else{
                $items[$key]->checkoutDate = Carbon::createFromFormat('d/m/Y', '01/12/2100');
            }
        }

        $items = $items->sortBy(function($query){
            return $query->checkoutDate;
        })->all();

        $waitingTime = [];
        $dateNow = Carbon::now()->format('Y-m-d');
        foreach($items as $key => $date){
            $createdAt =  $date->created_at->format('Y-m-d');
            $waitingTime[$key] = Carbon::parse($createdAt)->diffInDays($dateNow); 
        }

        return view('engraving.index', compact('budgets', 'search', 'items', 'waitingTime'));
    }

    public function show($budget){
        $budgetInfos = Adderi::budget()->show($budget);
        $budgetInfos = $budgetInfos->json();

        $budget = Budget::where('adderi_budget', $budget)->first();

        $fone = 'Não Informado';

        if($budgetInfos['data']['customer']['0']['fones'] != []){
            foreach($budgetInfos['data']['customer']['0']['fones'] as $fones){
                if($fones['ativo'] == 1 && $fones['principal'] == 1){
                    $fone = $fones['fone'];
                }
            }
        }

        return view('engraving.show', compact('budget', 'budgetInfos', 'fone'));
    }

    public function updateEngraving($item){
        $budgetItem = BudgetItem::find($item);
        $budgetItem->engraving = Carbon::now()->format("Y-m-d H:i:s");
        $budgetItem->user_engraving = Auth::user()->id;
        $budgetItem->save();

        $budget = Budget::findOrFail($budgetItem->budget_id);

        if($budget->itemBudget()->whereNull('engraving')->count() >= 1){
            return redirect()->route('engraving.show', $budgetItem->budget->adderi_budget)->with('success', 'Gravação realizada com sucesso');
        }
        $budget->status = BudgetStatus::finished;
        $budget->save();
        return redirect()->route('engraving.index')->with('success', 'Gravação realizada com sucesso');
    }

    public function store(Request $request){
        $error = new Error();
        $error->error = $request->erro;
        $error->id_item = $request->id_item;
        $error->id_usuario = Auth::user()->id;
        $error->save();

        $budget = $request->budget;
        return redirect()->route('engraving.show', $budget)->with('success', 'Erro cadastrado com sucesso');
    }
}
