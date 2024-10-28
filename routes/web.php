<?php

use App\Http\Controllers\EditionController;
use App\Http\Controllers\EngravingController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\LocateController;
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\ProduceController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Search;
use PhpParser\Node\Stmt\Return_;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['auth'])->group(function (){
    Route::get('/', function () {
        return view('welcome');
    });

    Route::resource('role', RoleController::class);

    Route::resource("hotel", HotelController::class);

    Route::resource('orcamento', OrcamentoController::class)->only(['index','store']);
    Route::post('/orcamento/busca', [OrcamentoController::class, 'search'])->name('orcamento.search');
    Route::get('orcamento/busca/entrega', [OrcamentoController::class, 'delivery'])->name('orcamento.delivery');
    Route::get('orcamento/busca/entrega/visualizar/{budget}', [OrcamentoController::class, 'showDelivery'])->name('orcamento.delivery.show');

    Route::resource("edition", EditionController::class)->only('index', 'show');
    Route::get('edition/corte/{budget}', [EditionController::class, 'updateCorte'])->name('edition.updateCorte');
    Route::get('edition/edicao/{budget}', [EditionController::class, 'updateEdition'])->name('edition.updateEdition');
    Route::get('edition/layout/{budget}', [EditionController::class, 'updateLayout'])->name('edition.updateLayout');

    Route::resource('engraving', EngravingController::class);
    Route::get('engraving/action/{budget}', [EngravingController::class, 'updateEngraving'])->name('engraving.updateEngraving');

    Route::resource('locate', LocateController::class)->only(['index','edit']);
    Route::get('locate/show', [LocateController::class, 'show'])->name('locate.show');
    Route::post('locate/show/print', [LocateController::class, 'print'])->name('locate.print');

    Route::resource('printer', PrinterController::class)->only(['create', 'store']);

    Route::resource("report", ReportController::class)->only(['index']);
    Route::get('report/search', [ReportController::class, 'search'])->name('report.search');
    Route::get('report/sla', [ReportController::class, 'indexSla'])->name('reportSla');
    Route::get('report/sla/searchSla', [ReportController::class, 'searchSla'])->name('searchSla');

    Route::get('report/show/export', [UsersController::class, 'export']);
});

    require __DIR__.'/auth.php';
