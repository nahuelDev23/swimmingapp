<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Club;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
   
    public function index()
    {
        $users = User::all();
        return view('users/index',[
            'users'=>$users,
        ]);
    }

    public function create()
    {
        $clubs = Club::pluck('nombre_club','id');
        return view('users/create',[
            'clubs' => $clubs,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'club_id' => 'required|max:3',
            'password' => 'required|confirmed|min:6',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->club_id = $request->club_id;
        $user->password = Hash::make($request->password);

       $user->save();

       return redirect('users')->with('success','El usuario se creo con exito');
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit(User $user)
    {
        $clubs = Club::pluck('nombre_club','id');
        return view('users/edit',[
            'user' => $user,
            'clubs'=>$clubs,
        ]);
    }

   
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'club_id' => 'required|max:3',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->club_id = $request->club_id;
        $user->update();

        return back()->with('success','El usuario se editó con exito');

    }

    public function destroy($id)
    {
       
    }

    public function reset_password(Request $request){
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $id = Auth::id();
        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->password_changed_at = 1;
        $user->update();

        return redirect('dashboard');
    }
}
