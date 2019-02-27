<?php

namespace App\Http\Controllers;

use App\AuditTrail;
use App\Category;
use App\DataTables\CategoryDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(CategoryDataTable $dataTable){
        return $dataTable->render('admin.category.index',[
            'page' => (object) ['title' => 'Category']

        ]);

    }
    public function create(Request $request)
    {

        if (strtoupper($request->method()) == 'POST')
        {

            $user = auth()->user();
            $this->validate($request, [
                'name'=>'required',
            ]);

            $inputs = $request->all();
            $inputs['done_by']= $user->id;
            Category::create($inputs);

            $request->session()->flash('success', 'Category: '.$request->name.' Saved successfully!');
            AuditTrail::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'region_id' => $user->region_id,
                'date' => Carbon::now()->toDateTimeString(),
                'activity' => $user->username.','.' ' .'Added a new Category: '.$request->name.''
            ]);
            return redirect()->back();
        }

        return view('admin.category.create', [
            'page' => (object) ['title' => 'Category']

        ]);
    }
    public function edit(Request $request, $id)
    {
        $data = Category::findOrFail($id);

        if (strtoupper($request->method()) == 'POST')
        {

            $user = auth()->user();
            $this->validate($request, [
                'name' => 'required',
            ]);

            $inputs = $request->all();
            $inputs['done_by']= $user->id;
            $data->update($inputs);

            $request->session()->flash('success', 'Category: '.$data->name.' updated successfully!');
            AuditTrail::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'region_id' => $user->region_id,
                'date' => Carbon::now()->toDateTimeString(),
                'activity' => $user->username.'Edited a Category: '.$data->name.''
            ]);
            return redirect()->route('settings.category.index');
        }

        return view('admin.category.edit', [
            'data' => $data,
            'page' => (object) ['title' => 'Edit Category']

        ]);
    }

    public function delete($id){
        $record = Category::findOrFail($id);

        $record->delete();

        //create log entry
        $user = Auth::user();
        AuditTrail::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'region_id' => $user->region_id,
            'date' => Carbon::now()->toDateTimeString(),
            'activity' => $user->username.' deleted Category: '.$record->name.''
        ]);

        session()->flash('success', ''.$record->name.'  was successfully deleted!');
        return redirect()->back();

    }
}
