<?php

namespace App\Http\Controllers;

use App\AuditTrail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function create(Request $request)
    {

        if (strtoupper($request->method()) == 'POST')
        {

            $user = auth()->user();
            $this->validate($request, [
                'name'=>'required',
            ]);

            $inputs = $request->all();
            $inputs['guard_name']= 'web';
            Permission::create($inputs);

            $request->session()->flash('success', 'Permission: '.$request->name.' Saved successfully!');
            AuditTrail::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'region_id' => $user->region_id,
                'date' => Carbon::now()->toDateTimeString(),
                'activity' => $user->username.','.' ' .'Added a new permission: '.$request->name.''
            ]);
            return redirect()->back();
        }

        return view('permission.create', [
            'page' => (object) ['title' => 'Permission']

        ]);
    }
}
