<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;


class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);

    }

    public function index(Request $request){
        $this->validate($request, [
            'search' => 'nullable|string'
        ]);

        $breadcrumbs = [
            ['name' => "Usuários"], ['name' => "Listagem de usuário"],
        ];

        $search = $request->input('search');

        $users = User::when($search !== null, function ($query) use ($search){
                        $query->where('name', 'like', '%'.$search.'%')
                                ->orWhere('email', 'like', '%'.$search.'%');
                    })
                    ->orderBy('name', 'asc')
                    ->paginate(20);

        return view('auth.index', compact( 'users', 'search'));
    }

    public function edit($id){
        $breadcrumbs = [
            ['name' => "Usuários"], ['name' => "Edição de usuário"],
        ];

        $roles = Role::orderBy('name', 'asc')->get();

        $user = User::findOrFail($id);
        return view('auth.edit', compact('user', 'breadcrumbs', 'roles'));
    }

    public function update(Request $request, $id){
        $this->validate( $request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,id,'.$id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => ['required', 'exists:roles,name']
        ]);

        $user = User::findOrFail($id);
        $user->fill([
           'name' => $request->input('name'),
           'email' => $request->input('email'),
        ]);

        if ($request->input('password') !== null){
            $user->password = Hash::make($request->input('passoword'));
        }
        $user->save();

        $user->syncRoles($request->input('role'));

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy($user){
        $user = User::findOrFail($user);
        $user->delete();
        return redirect()->route('usuarios.index');
    }
}
