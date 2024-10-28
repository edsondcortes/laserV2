<?php

namespace App\Http\Controllers;

use App\Services\Facades\Adderi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //

    function __construct()
    {
        $this->middleware('permission:role-list', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $breadcrumbs = [
            ['name' => "Permissões"], ['name' => "Listagem de níveis de acesso"],
        ];

        $search = '';

        $roles = Role::orderBY('name', 'asc')->paginate(20);
        return view('role.index',compact('roles', 'breadcrumbs', 'search'));
    }


    public function create()
    {
        $breadcrumbs = [
            ['name' => "Permissões"], ['name' => "Criar nível de acesso"],
        ];

        $permission = Permission::get();
        return view('role.create',compact('permission', 'breadcrumbs'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => ['required'],
        ]);
        try{
            $role = Role::create(['name' =>  $request->input('name')]);
            $role->syncPermissions($request->input('permission'));
            return redirect()->route('role.index');
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $breadcrumbs = [
            ['name' => "Permissões"], ['name' => "Editar nível de acesso"],
        ];

        $role = Role::find($id);
        $permission = Permission::get();
        return view('role.edit',compact('role', 'permission', 'breadcrumbs'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => ['required'],
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');

        try {
            $role->save();
            $role->syncPermissions($request->input('permission'));
            return redirect()->route('role.index')->with('success','Nível de acesso atualizado com sucesso!');
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user_use_this_role = DB::table("model_has_roles")->where('role_id', $id)->count();
        if($user_use_this_role > 0)
        {
            return redirect()->route('role.index')->with('error','Existem usuários neste nível de acesso, favor realocar em algum outro.');
        }
        Role::find($id)->delete();
        return redirect()->route('role.index')->with('success','Nível de acesso removido!');
    }
}
