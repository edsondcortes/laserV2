<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\Delivery;
use App\Models\DeliveryOnTime;
use App\Models\HotelDelivery;
use App\Models\LocalDelivery;
use App\Models\Printer as ModelsPrinter;
use App\Models\SeasonDelivery;
use App\Services\Facades\Adderi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;

class LocateController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:requests-locate', ['only' => ['index', 'show', 'print']]);
        $this->middleware('auth');
    }

    public function index(){
        return view('locate.index');
    }

    public function show(Request $request){
        $numBudget = $request->input('orcamento');
        $numBudget = str_pad($numBudget, 10, 0, STR_PAD_LEFT);
        $numBudget = str_pad($numBudget,11, 1, STR_PAD_LEFT);

        $budget = Budget::where('adderi_budget', '=', $numBudget)
                        ->first();

        if($budget === null){
            return redirect()->route('locate.index')->with('error', "Não existe nenhum orçamento para o laser com este número!");
        }

        $budgetId = $budget['id'];

        $budgetItens = BudgetItem::select(['delivery_type', 'delivery_id'])
                            ->where('budget_id', $budgetId)
                            ->groupBy(['delivery_type', 'delivery_id'])
                            ->with(['delivery', 'delivery.budgetItem'])
                            ->get();

        $budgetInfos = Adderi::budget()->show($numBudget);
        $budgetInfos = $budgetInfos->json();

        $select = 'SELECIONE';
        $fone = 'Não Informado';

        if($budgetInfos['data']['customer']['0']['fones'] != []){
            foreach($budgetInfos['data']['customer']['0']['fones'] as $fones){
                if($fones['ativo'] == 1 && $fones['principal'] == 1){
                    $fone = $fones['fone'];
                }
            }
        }

        return view('locate.show', compact('budget', 'select', 'budgetInfos', 'fone', 'budgetItens'));
    }

    public function print(Request $request){
        $request = $request->all();

        $budget = Budget::find($request['budgetId']);
        $budgetItens = $budget->itemBudget()->where('delivery_id', $request['deliveryId'])->get();

        $budgetItem = $budgetItens->map(function ($budgetItem){
            date_default_timezone_set('America/Sao_Paulo');
            $date = date('Y-m-d H:i:s');
            $budgetItem->product_delivery = $date;
            $budgetItem->save();
        });

        $numberBudget = Adderi::reduceNumber($budget->adderi_budget);

        $budgetInfo = Adderi::budget()->show($budget->adderi_budget);
        $budgetInfo = $budgetInfo->json();

        $cpfCnpj = $budgetInfo['data']['customer']['0']['cnpjcpfidestrangeiro'];
        $fone = 'Não Informado';

        if($budgetInfo['data']['customer']['0']['fones'] != []){
            foreach($budgetInfo['data']['customer']['0']['fones'] as $fones){
                if($fones['ativo'] == 1 && $fones['principal'] == 1){
                    $fone = $fones['fone'];
                    $fone = "(" . substr($fone, 0, 2) . ") " . substr($fone, 2, 5) . "-" . substr($fone, 7);
                }
            }
        }

        if (strlen($cpfCnpj) === 11) {
            $document = substr($cpfCnpj, 0, 3) . '.' . substr($cpfCnpj, 3, 3) . '.' . substr($cpfCnpj, 6, 3) . '-' . substr($cpfCnpj, 9, 2);
        } elseif (strlen($cpfCnpj) === 14) {
            $document = substr($cpfCnpj, 0, 2) . '.' . substr($cpfCnpj, 2, 3) . '.' . substr($cpfCnpj, 5, 3) . '/' . substr($cpfCnpj, 8, 4) . '-' . substr($cpfCnpj, 12, 2);
        } else {
            $document = 'Não Informado';
        }

        $modelPrinter = ModelsPrinter::find(1);
        $connector = new NetworkPrintConnector($modelPrinter->printer_ip, $modelPrinter->printer_port);
                    $printer = new Printer($connector);

                    $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
                    $printer->feed(1);
                    $printer->setTextSize(2, 2);
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->text('Formulário de Entrega');
                    $printer->feed(1);
                    $printer->setTextSize(2, 2);
                    $printer->text('Via Cliente');
                    $printer->feed(1);
                    $printer->setTextSize(1, 1);
                    $printer->text('Cristais de Gramado');
                    $printer->feed(1);
                    $printer->setTextSize(2, 2);
                    $printer->text('---------------------');
                    $printer->feed(1);
                    $printer->text('Pulseira: ' .$budgetInfo['data']['atendimento']);
                    $printer->feed(1);
                    $printer->setTextSize(1, 1);
                    $printer->text('Orçamento: ' .$numberBudget);
                    $printer->feed(1);
                    $printer->text('Cliente: ' .$budgetInfo['data']['customer']['0']['nomerazaosocial']);
                    $printer->feed(1);
                    $printer->text('CPF/CNPJ: ' .$document);
                    $printer->feed(1);
                    $printer->text('Telefone: ' .$fone);
                    $printer->feed(1);
                    $printer->text('Data e hora de emissão:' .date('d/m/Y H:i:s'));
                    $printer->feed(1);
                    $printer->text('-----------------------------------------');
                    $printer->feed(1);

                    if($budgetItens['0']['delivery_type'] == LocalDelivery::class){
                        $budgetItem = $budgetItens['0'];
                        $dateHour = $budgetItem->delivery->date_time_delivery->format('d/m/Y - H:i');
                        $printer->setTextSize(1, 1);
                        $printer->text('Data e hora de Entrega');
                        $printer->feed(1);
                        $printer->setTextSize(2, 2);
                        $printer->text($dateHour);
                        $printer->feed(1);
                        $printer->setTextSize(1, 1);
                        $printer->text('-----------------------------------------');
                    }
                    if($budgetItens['0']['delivery_type'] == HotelDelivery::class){
                        $budgetItem = $budgetItens['0'];
                        $dateHour = $budgetItem->delivery->output_date_time->format('d/m/Y - H:i');
                        $printer->setTextSize(1, 1);
                        $printer->text('Hotel');
                        $printer->feed(1);
                        $printer->setTextSize(2, 2);
                        $printer->text($budgetItem->delivery->hotel->name);
                        $printer->feed(1);
                        $printer->setTextSize(1, 1);
                        $printer->text('Quarto');
                        $printer->feed(1);
                        $printer->setTextSize(2, 2);
                        $printer->text($budgetItem->delivery->room);
                        $printer->feed(1);
                        $printer->setTextSize(1 ,1);
                        $printer->text('Data e hora de Entrega');
                        $printer->feed(1);
                        $printer->setTextSize(2, 2);
                        $printer->text($dateHour);
                        $printer->feed(1);
                        $printer->setTextSize(1 ,1);
                        $printer->text('-----------------------------------------');
                    }
                    if($budgetItens['0']['delivery_type'] == SeasonDelivery::class){
                        $budgetItem = $budgetItens['0'];
                        $dateHour = $budgetItem->delivery->delivery_date_time->format('d/m/Y - H:i');
                        $outputDate = $budgetItem->delivery->output_date->format('d/m/Y');
                        $printer->setTextSize(1, 1);
                        $printer->text('Bairro');
                        $printer->feed(1);
                        $printer->setTextSize(2, 2);
                        $printer->text($budgetItem->delivery->district);
                        $printer->feed(1);
                        $printer->setTextSize(1, 1);
                        $printer->text('Rua');
                        $printer->feed(1);
                        $printer->setTextSize(2, 2);
                        $printer->text($budgetItem->delivery->street);
                        $printer->feed(1);
                        $printer->setTextSize(1, 1);
                        $printer->text('Número');
                        $printer->feed(1);
                        $printer->setTextSize(2, 2);
                        $printer->text($budgetItem->delivery->number);
                        $printer->feed(1);
                        $printer->setTextSize(1, 1);
                        $printer->text('Data e hora de Entrega');
                        $printer->feed(1);
                        $printer->setTextSize(2, 2);
                        $printer->text($dateHour);
                        $printer->feed(1);
                        $printer->setTextSize(1, 1);
                        $printer->text('Data de saída: ' .$outputDate);
                        $printer->feed(1);
                        $printer->text('Complemento: ' .$budgetItem->delivery->complement);
                        $printer->feed(1);
                        $printer->text('-----------------------------------------');
                    }
                    if($budgetItens['0']['delivery_type'] == DeliveryOnTime::class){
                        $printer->text('-----------------------------------------');
                    }
                    $printer->feed(1);
                    $printer->setTextSize(2, 2);
                    $printer->text('Itens');
                    $printer->feed(1);
                    $printer->setTextSize(1, 1);

                    foreach($budgetItens as $item){
                        $printer->text($item->item_code. ' - ' .$item->description);
                        $printer->feed(1);
                        $printer->text('-----------------------------------------');
                        $printer->feed(1);
                    }

                    $printer->text('Sacolas: ' .$request['sacolas']);
                    $printer->feed(1);
                    $printer->text('Entrega realizada: ' .mb_convert_case($request['entrega']['0'], MB_CASE_TITLE, "UTF-8"));

                    if($budgetItens['0']['delivery_type'] != Delivery::class){
                        $printer->feed(1);
                        $printer->text('-----------------------------------------');
                        $printer->feed(1);
                        $printer->text('Site: www.cristaisdegramado.com.br');
                        $printer->feed(1);
                        $printer->text('Fone: (54) 3286 - 0100');
                        $printer->feed(1);
                        $printer->text('Email: falecom@cristaisdegramado.com.br');
                        $printer->feed(2);
                        $printer->text('Fábrica/Loja');
                        $printer->feed(1);
                        $printer->text('RS-115 KM 36 Nº 36161');
                        $printer->feed(1);
                        $printer->text('Várzea Grande - Gramado-RS');
                    }

                    $printer->feed(3);

                    $printer->cut();

                    if($budgetItens['0']['delivery_type'] != Delivery::class && $budgetItens['0']['delivery_type'] != DeliveryOnTime::class){
                        $printer->feed(1);
                        $printer->setTextSize(2, 2);
                        $printer->text('Formulário de Entrega');
                        $printer->feed(1);
                        $printer->setTextSize(1, 1);
                        $printer->text('Via Cristais de Gramado');
                        $printer->feed(1);
                        $printer->setTextSize(2, 2);
                        $printer->text('---------------------');
                        $printer->feed(1);
                        $printer->setTextSize(1, 1);
                        $printer->text('Orçamento: ' .$numberBudget);
                        $printer->feed(1);
                        $printer->text('Cliente: ' .$budgetInfo['data']['customer']['0']['nomerazaosocial']);
                        $printer->feed(1);
                        $printer->text('CPF/CNPJ: ' .$document);
                        $printer->feed(1);
                        $printer->text('Telefone: ' .$fone);
                        $printer->feed(1);
                        $printer->text('Data e hora de emissão:' .date('d/m/Y H:i:s'));
                        $printer->feed(1);
                        $printer->text('-----------------------------------------');
                        $printer->feed(1);

                        if($budgetItem->delivery_type == HotelDelivery::class){
                            $dateHour = $budgetItem->delivery->output_date_time->format('d/m/Y - H:i');
                            $printer->setTextSize(1, 1);
                            $printer->text('Hotel');
                            $printer->feed(1);
                            $printer->text($budgetItem->delivery->hotel->name);
                            $printer->feed(2);
                            $printer->text('Quarto');
                            $printer->feed(1);
                            $printer->text($budgetItem->delivery->room);
                            $printer->feed(2);
                            $printer->text('Data e hora de Entrega');
                            $printer->feed(1);
                            $printer->text($dateHour);
                            $printer->feed(1);
                            $printer->text('-----------------------------------------');
                            $printer->feed(1);
                        }

                        $printer->setTextSize(2, 2);
                        $printer->text('Itens');
                        $printer->setTextSize(1, 1);
                        $printer->feed(1);

                        foreach($budgetItens as $item){
                            $printer->text($item->item_code. ' - ' .$item->description);
                            $printer->feed(1);
                            $printer->text('-----------------------------------------');
                            $printer->feed(1);
                        }

                        $printer->text('Sacolas: ' .$request['sacolas']);
                        $printer->feed(1);
                        $printer->text('Entrega realizada: ' .mb_convert_case($request['entrega']['0'], MB_CASE_TITLE, "UTF-8"));
                        $printer->feed(1);
                        $printer->text('-----------------------------------------');
                        $printer->feed(3);
                        $printer->setTextSize(2, 2);
                        $printer->text('_____________________');
                        $printer->setTextSize(1, 1);
                        $printer->feed(1);
                        $printer->text('Ass. Responsável pela entrega');
                        $printer->feed(2);
                        $printer->text('Horário: ______h______min');
                        $printer->feed(2);
                        $printer->text('Data: _____/_____/______');
                        $printer->feed(3);
                        $printer->setTextSize(2, 2);
                        $printer->text('_____________________');
                        $printer->setTextSize(1, 1);
                        $printer->feed(1);
                        $printer->text('Ass. Cliente');
                        $printer->feed(3);
                        $printer->cut();
                    }

                    $printer->close();

        return redirect(route('locate.show', ["orcamento" => $numberBudget]))->with('success', "Impressão realizada com sucesso!");
    }
}
