<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Club;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users/index',[
            'users'=>$users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clubs = Club::pluck('nombre_club','id');
        return view('users/create',[
            'clubs' => $clubs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

       return back()->with('success','El usuario se creo con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $clubs = Club::pluck('nombre_club','id');
        return view('users/edit',[
            'user' => $user,
            'clubs'=>$clubs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'club_id' => 'required|max:3',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->club_id = $request->club_id; #no edita el club
        $user->update();

        return back()->with('success','El usuario se editó con exito');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
