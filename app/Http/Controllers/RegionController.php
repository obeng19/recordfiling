<?php

namespace App\Http\Controllers;

use App\AuditTrail;
use App\DataTables\RegionDatatTableDataTable;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RegionController extends Controller
{
    public function index(RegionDatatTableDataTable $dataTable){
        return $dataTable->render('admin.regions.index',[
            'page' => (object) ['title' => 'Regions']

        ]);

    }
    public function create(Request $request)
    {

        if (strtoupper($request->method()) == 'POST')
        {

            $user = auth()->user();
            $this->validate($request, [
                'name'=>'required',
                'code'=>'required',
            ]);

            $inputs = $request->all();
            $inputs['done_by']= $user->id;
            Region::create($inputs);

            $request->session()->flash('success', 'Region: '.$request->name.' Saved successfully!');
            AuditTrail::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'region_id' => $user->region_id,
                'date' => Carbon::now()->toDateTimeString(),
                'activity' => $user->username.','.' ' .'Added a new region: '.$request->name.''
            ]);
            return redirect()->back();
        }

        return view('admin.regions.create', [
            'page' => (object) ['title' => 'Regions']

        ]);
    }
    public function edit(Request $request, $id)
    {
        $data = Region::findOrFail($id);

        if (strtoupper($request->method()) == 'POST')
        {

            $user = auth()->user();
            $this->validate($request, [
                'name' => 'required',
                'code' => 'required'
            ]);

            $inputs = $request->all();
            $inputs['done_by']= $user->id;
            $data->update($inputs);

            $request->session()->flash('success', 'Region: '.$data->name.' updated successfully!');
            AuditTrail::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'region_id' => $user->region_id,
                'date' => Carbon::now()->toDateTimeString(),
                'activity' => $user->username.'Edited a region: '.$data->name.''
            ]);
            return redirect()->route('settings.regions.index');
        }

        return view('admin.regions.edit', [
            'data' => $data,
            'page' => (object) ['title' => 'Edit Region']

        ]);
    }

    public function delete($id){
        $record = Region::findOrFail($id);

        $record->delete();

        //create log entry
        $user = Auth::user();
        AuditTrail::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'region_id' => $user->region_id,
            'date' => Carbon::now()->toDateTimeString(),
            'activity' => $user->username.' deleted Region: '.$record->name.''
        ]);

        session()->flash('success', ''.$record->name.'  was successfully deleted!');
        return redirect()->back();

    }
}
