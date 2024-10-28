<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class HotelController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:hotel-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:hotel-list', ['only' => ['index', 'update', 'destroy']]);
        $this->middleware('auth');
    }

    public function create(){
        return view("hotel.create");
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nomeHotel' => 'required',
            'nomeRua' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'telefone' => 'required',
        ]);

        $telefone =  preg_replace("/[^a-zA-Z0-9]/", "", $request->input('telefone'));

        $hotel = Hotel::create([
           'name' => $request->input('nomeHotel'),
           'street' => $request->input('nomeRua'),
           'number' => $request->input('numero'),
           'district' => $request->input('bairro'),
           'city' => $request->input('cidade'),
           'fone' => $telefone,
        ]);

        return redirect()->back()->with('success', 'Hotel cadastrado com sucesso!');
    }

    public function index(Request $request){
        $this->validate($request, [
            'search' => 'nullable|string',
        ]);

        $search = $request->input('search');

        $hotels = Hotel::when($search !== null, function ($query) use ($search){
                        $query->where('name', 'like', '%'.$search.'%');
        })
        ->orderBy('name')
        ->paginate(20);
        return view('hotel.list',compact('hotels', 'search'));
    }

    public function edit($hotelList){
        $editHotel = Hotel::find($hotelList);
        return view('hotel.edit', compact('editHotel'));
    }

    public function update(Request $request, $editHotel){
        $telefone =  preg_replace("/[^a-zA-Z0-9]/", "", $request->fone);

        $updateHotel = Hotel::find($editHotel);
        $updateHotel->name = $request->name;
        $updateHotel->street = $request->street;
        $updateHotel->number = $request->number;
        $updateHotel->district = $request->district;
        $updateHotel->city = $request->city;
        $updateHotel->fone = $telefone;
        $updateHotel->save();

        return redirect()->route('hotel.index')->with('success', 'Hotel foi atualizado com sucesso!');
    }

    public function destroy($hotelList){
        $hotelList = Hotel::findOrFail($hotelList);
        $hotelList->delete();
        dd($hotelList);
        return redirect()->route('hotel.index')->with('success', 'Hotel excluído com sucesso!');
    }
}
