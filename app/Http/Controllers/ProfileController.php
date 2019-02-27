<?php

namespace App\Http\Controllers;

use App\AuditTrail;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $auth=auth()->user()->id;
        $data = User::query()->where('id',$auth)->first();
//        $roles = Role::orderBy('name')->get(['id', 'name']);
        return view('profile.edit', [
            'data'   => $data,
//            'roles'  => $roles,
            'page' => (object) ['title' => 'My Profile']

        ]);
    }
    public function update(Request $request, $id)
    {
        $data = User::with('role')->findOrFail($id);
        $_user = Auth::user();

        $this->validate($request, [
            'first_name'=> 'required',
            'last_name' => 'required',
            'official_phone' => 'required',
            'email'     => 'required|email|unique:users,email,'.$id
        ]);

        $inputs = $request->except(['password']);
        $inputs['name'] = $inputs['first_name'].' '.$inputs['last_name'];

        if ($request['password'] != null)
        {
            $this->validate($request, ['password' => 'min:6']);
            $inputs['password'] = bcrypt($request['password']);
        }
        if($request->hasFile('avatar')){
            $image = $request->file('avatar');
            $path = public_path(). '/profile/';
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);
            $inputs['avatar']=$filename;
            $data->update($inputs);
        }else{
            $data->update($inputs);
        }

        // create log entry
        $user = Auth::user();
        AuditTrail::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'region_id' => $user->region_id,
            'hospital_id' => $user->hospital_id,
            'date' => Carbon::now()->toDateTimeString(),
            'activity' => $user->username.' updated Profile: '.$inputs['name']
        ]);

        $request->session()->flash('success', 'The User '.$inputs['first_name'].' '.$inputs['last_name'].' was successfully updated!');
        return redirect()->back();
    }
}
