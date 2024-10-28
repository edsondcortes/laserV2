<?php

namespace App\Http\Controllers;

use App\Exports\RegistrationsExport;
use App\Exports\SlaExport;
use App\Models\Budget;
use Illuminate\Http\Request;
use App\Models\BudgetItem;
use Carbon\Carbon;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:report-search', ['only' => ['index', 'search']]);
        $this->middleware('auth');
    }
    /** FUNÇÕES QUE PESQUISAM OS ORÇAMENTOS */
    public function index(){
        return view('report.index');
    }

    public function search(Request $request){
        $request = $request->all();
        $dates = explode(' to ', $request['rangeCalendar']);

        $dateStart = Carbon::createFromFormat('d-m-Y', $dates['0'])->format('Y-m-d');
        if(array_key_exists('1', $dates)){
            $dateEnd = Carbon::createFromFormat('d-m-Y', $dates['1'])->format('Y-m-d');

                $budgets = Budget::join('budget_items', 'budgets.id', '=', 'budget_items.budget_id')
                ->select(
                    'budgets.adderi_budget',
                    'budget_items.item_code',
                    'budget_items.description',
                    'budget_items.position',
                    'budget_items.type',
                    'budget_items.note',
                    'budget_items.created_at'
                )
                ->whereBetween('budgets.created_at', [$dateStart, $dateEnd])
                ->get();
        }else{
            $budgets = Budget::join('budget_items', 'budgets.id', '=', 'budget_items.budget_id')
            ->select(
                'budgets.adderi_budget',
                'budget_items.item_code',
                'budget_items.description',
                'budget_items.position',
                'budget_items.type',
                'budget_items.note',

                'budget_items.created_at'
            )
            ->whereDate('budgets.created_at', '=', $dateStart)
            ->get();
        }

        return Excel::download(new RegistrationsExport($budgets), 'Cadastro de Itens.xlsx');
    }

    /**FUNÇÕES QUE FAZEM O RELATÓRIO SOBRE OS TEMPOS EM CADA ETAPA */
    public function indexSla(){
        return view('report.indexSla');
    }

    public function searchSla(Request $request){
        $request = $request->all();
        $dates = explode(' to ', $request['rangeCalendar']);

        $dateStart = Carbon::createFromFormat('d-m-Y', $dates['0'])->format('Y-m-d');

        if(array_key_exists('1', $dates)){
            $dateEnd = Carbon::createFromFormat('d-m-Y', $dates['1'])->format('Y-m-d');

            $budgets = Budget::join('budget_items', 'budgets.id', '=', 'budget_items.budget_id')
            ->select(
                'budgets.adderi_budget',
                'budget_items.item_code',
                'budget_items.description',
                'budget_items.delivery_type',
                'budget_items.cut',
                'budget_items.edition',
                'budget_items.layout',
                'budget_items.engraving',
                'budget_items.created_at',
                'budget_items.product_delivery'
            )
            ->whereBetween('budgets.created_at', [$dateStart, $dateEnd])
            ->get();
        }else{
            $budgets = Budget::join('budget_items', 'budgets.id', '=', 'budget_items.budget_id')
            ->select(
                'budgets.adderi_budget',
                'budget_items.item_code',
                'budget_items.description',
                'budget_items.delivery_type',
                'budget_items.created_at',
                'budget_items.cut',
                'budget_items.edition',
                'budget_items.layout',
                'budget_items.engraving',
                'budget_items.product_delivery'
            )
            ->whereBetween('budgets.created_at', [$dateStart])
            ->get();
        }
        //dd($budgets);
        $budget = $budgets->map(function ($budget){
            $budgetCreatedAt = Carbon::parse($budget->created_at);
            $budgetCut = Carbon::parse($budget->cut);
            $budgetEdition = Carbon::parse($budget->edition);
            $budgetLayout = Carbon::parse($budget->layout);
            $budgetEngraving = Carbon::parse($budget->engraving);
            $budgetProductDelivery = Carbon::parse($budget->product_delivery);

            $budget->differenceCut = $budgetCut->diff($budgetCreatedAt);
            $budget->differenceEdition = $budgetCut->diff($budgetEdition);
            $budget->differenceLayout = $budgetEdition->diff($budgetLayout);
            $budget->differenceEngraving = $budgetEngraving->diff($budgetLayout);
            $budget->differenceProductDelivery = $budgetProductDelivery->diff($budgetCreatedAt);

            $budget->differenceCut = $budget->differenceCut->format('%d - %H:%I:%S');
            $budget->differenceEdition = $budget->differenceEdition->format('%d - %H:%I:%S');
            $budget->differenceLayout = $budget->differenceLayout->format('%d - %H:%I:%S');
            $budget->differenceEngraving = $budget->differenceEngraving->format('%d - %H:%I:%S');
            $budget->differenceProductDelivery = $budget->differenceProductDelivery->format('%d - %H:%I:%S');

            if($budget->delivery_type == 'App\Models\LocalDelivery'){
                $budget->delivery_type = 'Vem Buscar';
            }
            if($budget->delivery_type == 'App\Models\HotelDelivery'){
                $budget->delivery_type = 'Hotel';
            }
            if($budget->delivery_type == 'App\Models\SeasonDelivery'){
                $budget->delivery_type = 'Temporada';
            }
            if($budget->delivery_type == 'App\Models\Delivery'){
                $budget->delivery_type = 'Despachar';
            }
            if($budget->delivery_type == 'App\Models\DeliveryOnTime'){
                $budget->delivery_type = 'Entrega na hora';
            }
        });

        return Excel::download(new SlaExport($budgets), 'Relatório de Tempo.xlsx');
    }
}
