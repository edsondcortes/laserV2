<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:printers', ['only' => ['create', 'store']]);
        $this->middleware('auth');
    }

    public function create(){
        $printer = Printer::where('id', '!=', null)
                            ->first();

        return view('printer.create', compact('printer'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'printer_name' => 'required',
            'printer_ip' => 'required',
            'printer_port' => 'required|numeric'
        ]);

        $printer = Printer::find(1);

        if($printer == null){
            $printer = new Printer();
        }

        $printer->printer_name = $request->input('printer_name');
        $printer->printer_ip = $request->input('printer_ip');
        $printer->printer_port = $request->input('printer_port');
        $printer->save();

        return redirect()->route('printer.create')->with('success', 'Impressora atualizada com sucesso!');
    }
}
