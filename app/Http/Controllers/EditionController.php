<?php

namespace App\Http\Controllers;

use App\Enums\BudgetStatus;
use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\Delivery;
use App\Models\HotelDelivery;
use App\Models\LocalDelivery;
use App\Models\SeasonDelivery;
use App\Services\Facades\Adderi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class EditionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:requests-edition', ['only' => ['index','show', 'updateCorte', 'updateEdition',
                                                                        'updateLayout', 'verifyComplete']]);
        $this->middleware('auth');
    }

    public function index(Request $request){
        $search = $request->input('search');

        $items = Budget::where('status', '=', BudgetStatus::Edition)
            ->when($search !== null, function ($query) use ($search){
                $query->where('adderi_budget', 'like', '%'.$search.'%');
            })->with(['itemBudget', 'itemBudget.delivery'])
            ->get();

        //pluck transforma o valor da colection em array
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
            $createdAt =  $date->created_at->format('Y-m-d');;
            $waitingTime[$key] = Carbon::parse($createdAt)->diffInDays($dateNow);
        }

        $waitingTime = [];
        $dateNow = Carbon::now()->format('Y-m-d');
        foreach($items as $key => $date){
            $createdAt =  $date->created_at;
            $waitingTime[$key] = Carbon::parse($createdAt)->diffInDays($dateNow);
        }

        return view("edition.index", compact('budgets', 'search', 'items', 'waitingTime'));
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

        return view('edition.show', compact('budgetInfos', 'budget', 'fone'));
    }

    public function updateCorte($item){
        $budgetItem = BudgetItem::find($item);
        $budgetItem->cut = Carbon::now()->format('Y-m-d H:i:s');
        $budgetItem->user_cut = Auth::user()->id;
        $budgetItem->save();
        $complete = $this->verifyComplete($budgetItem->budget->id);
        if($complete == true){
            return redirect()->route('edition.index')->with('success', 'Corte realizado com sucesso!');
        }
        return redirect()->route('edition.show', $budgetItem->budget->adderi_budget)->with('success', 'Corte realizado com sucesso!');
    }

    public function updateEdition($item){
        $budgetItem = BudgetItem::find($item);
        $budgetItem->edition = Carbon::now()->format("Y-m-d H:i:s");
        $budgetItem->user_edition = Auth::user()->id;
        $budgetItem->save();
        $complete = $this->verifyComplete($budgetItem->budget->id);
        if($complete == true){
            return redirect()->route('edition.index')->with('success', 'Edição realizada com sucesso!');
        }
        return redirect()->route('edition.show', $budgetItem->budget->adderi_budget)->with('success', 'Edição realizada com sucesso!');
    }

    public function updateLayout($item){
        $budgetItem = BudgetItem::find($item);
        $budgetItem->layout = Carbon::now()->format("Y-m-d H:i:s");
        $budgetItem->user_layout = Auth::user()->id;
        $budgetItem->save();
        $complete = $this->verifyComplete($budgetItem->budget->id);
        if($complete == true){
            return redirect()->route('edition.index')->with('success', 'Layout realizado com sucesso!');
        }
        return redirect()->route('edition.show', $budgetItem->budget->adderi_budget)->with('success', 'Layout realizado com sucesso!');
    }

    private function verifyComplete($budget){
        $exists = BudgetItem::where(function($query){
                            $query->orWhereNull('edition')
                            ->orWhereNull('cut')
                            ->orWhereNull('layout');
                        })->where('budget_id', $budget)
                        ->count();

        if($exists == 0){
            $budget = Budget::find($budget);
            $budget->status = BudgetStatus::Engraving;
            $budget->save();
            return true;
        }
        return false;
    }
}
