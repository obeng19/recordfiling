<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(RoleDataTable $dataTable){
        return $dataTable->render('admin.role.index',[
            'page' => (object) ['title' => 'Role']

        ]);

    }
    public function create(Request $request)
    {
        if (strtoupper($request->method()) == 'POST')
        {

            $_user = auth()->user();
            $this->validate($request, [
                'name' => 'required',
                'code' => 'required'
            ]);

           $role= \Spatie\Permission\Models\Role::create([
               'name'=>$request->name,
               'code'=>$request->code,
               'guard_name'=>'web',
           ]);
           $role->syncPermissions($request->permission_id);

            $request->session()->flash('success', 'Role Saved Successfully!');
            return redirect()->back();
        }

        return view('admin.role.create', [
            'page' => (object) ['title' => 'Create Role']

        ]);
    }
    public function edit(Request $request, $id)
    {
        $item = Role::findOrFail($id);

        if (strtoupper($request->method()) == 'POST')
        {

            $_user = auth()->user();
            $this->validate($request, [
                'name' => 'required',
                'code' => 'required'
            ]);

            $inputs = $request->all();
            $item->update($inputs);

            $request->session()->flash('success', 'Role updated successfully!');
            return redirect()->route('management.role.index');
        }

        return view('admin.role.edit', [
            'data' => $item,
            'page' => (object) ['title' => 'Edit Role']

        ]);
    }
}
