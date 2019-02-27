<?php

namespace App\Http\Controllers;

use App\AuditTrail;
use App\DataTables\SubcategoryDataTable;
use App\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SubcategoryController extends Controller
{
    public function index(SubcategoryDataTable $dataTable){
        return $dataTable->render('admin.subcategory.index',[
            'page' => (object) ['title' => 'SubCategory']

        ]);

    }
    public function create(Request $request)
    {

        if (strtoupper($request->method()) == 'POST')
        {

            $user = auth()->user();
            $this->validate($request, [
                'cat_id'=>'required',
                'name'=>'required',
            ]);

            $inputs = $request->all();
            $inputs['done_by']= $user->id;
            Subcategory::create($inputs);

            $request->session()->flash('success', 'Subcategory: '.$request->name.' Saved successfully!');
            AuditTrail::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'region_id' => $user->region_id,
                'date' => Carbon::now()->toDateTimeString(),
                'activity' => $user->username.','.' ' .'Added a new Subcategory: '.$request->name.''
            ]);
            return redirect()->back();
        }

        return view('admin.subcategory.create', [
            'page' => (object) ['title' => 'SubCategory']

        ]);
    }
    public function edit(Request $request, $id)
    {
        $data = Subcategory::findOrFail($id);

        if (strtoupper($request->method()) == 'POST')
        {

            $user = auth()->user();
            $this->validate($request, [
                'cat_id' => 'required',
                'name' => 'required',
            ]);

            $inputs = $request->all();
            $inputs['done_by']= $user->id;
            $data->update($inputs);

            $request->session()->flash('success', 'Subcategory: '.$data->name.' updated successfully!');
            AuditTrail::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'region_id' => $user->region_id,
                'date' => Carbon::now()->toDateTimeString(),
                'activity' => $user->username.'Edited a Subcategory: '.$data->name.''
            ]);
            return redirect()->route('settings.subcategory.index');
        }

        return view('admin.subcategory.edit', [
            'data' => $data,
            'page' => (object) ['title' => 'Edit SubCategory']

        ]);
    }

    public function delete($id){
        $record = Subcategory::findOrFail($id);

        $record->delete();

        //create log entry
        $user = Auth::user();
        AuditTrail::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'region_id' => $user->region_id,
            'date' => Carbon::now()->toDateTimeString(),
            'activity' => $user->username.' deleted Subcategory: '.$record->name.''
        ]);

        session()->flash('success', ''.$record->name.'  was successfully deleted!');
        return redirect()->back();

    }
}
