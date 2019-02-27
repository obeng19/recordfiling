<?php

namespace App\Http\Controllers;

use App\AuditTrail;
use App\DataTables\FileDataTable;
use App\File;
use App\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class FileController extends Controller
{
    public function index(FileDataTable $dataTable){
        return $dataTable->render('file.index',[
            'page' => (object) ['title' => 'File']
        ]);
    }
    public function download($id)
    {
        $download = File::find($id);
        return response()->download(public_path() . "/document/" . $download->docs, $download->docs);
    }
    public function subcat($id){
        $sub=Subcategory::query()->where('cat_id',$id)->get();
        $data=(object)['sub'=>$sub];
        return response()->json($data) ;
    }
    public function create(Request $request){

        if (strtoupper($request->method()) == 'POST')
        {
            $user = auth()->user();
            $this->validate($request, [
                'docs' => 'required',
                'cat_id'=>'required',
                'subcat_id'=>'required',
            ]);

            $inputs = $request->all();
            $inputs['done_by'] = $user->id;
            $inputs['region_id'] = $user->region_id;
            if($request->hasFile('docs')){
                $file = $request->file('docs');
                foreach ($file as $files){
                    $path = public_path(). '/document/';
                    $filename = $files->getClientOriginalName();
                    $files->move($path, $filename);
                    $inputs['docs']=$filename;
                    File::create($inputs);
                }

            }
            AuditTrail::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'region_id' => $user->region_id,
                'date' => Carbon::now()->toDateTimeString(),
                'activity' => $user->username.'Added File: '
            ]);

            $request->session()->flash('success', 'File: Uploaded Successfully');
            return redirect()->back();
        }

        return view('file.create', [
            'page' => (object) ['title' => 'File']
        ]);

    }
    public function edit(Request $request,$id){
        $data=File::findOrFail($id);

        if (strtoupper($request->method()) == 'POST')
        {
            $user = auth()->user();
            $this->validate($request, [
                'docs' => 'required',
                'cat_id'=>'required',
                'subcat_id'=>'required',
            ]);

            $inputs = $request->all();
            $inputs['done_by'] = $user->id;
            $inputs['region_id'] = $user->region_id;
            if($request->hasFile('docs')){
                $file = $request->file('docs');
                foreach ($file as $files){
                    $path = public_path(). '/document/';
                    $filename = $files->getClientOriginalName();
                    $files->move($path, $filename);
                    $inputs['docs']=$filename;
                    $data->update($inputs);
                }

            }
            AuditTrail::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'region_id' => $user->region_id,
                'date' => Carbon::now()->toDateTimeString(),
                'activity' => $user->username.'Updated File: '
            ]);

            $request->session()->flash('success', 'File: Updated Successfully');
            return redirect()->route('file.docs.index');
        }

        return view('file.edit', [
            'page' => (object) ['title' => 'Edit File'],
            'data'=>$data
        ]);

    }
    public function delete($id) {
        $_user   = Auth::user();
        $record = File::findOrFail($id);

        $record->delete();

        //create log entry
        $user = Auth::user();
        AuditTrail::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'region_id' => $user->region_id,
            'date' => Carbon::now()->toDateTimeString(),
            'activity' => $user->username.'deleted File: '
        ]);

        session()->flash('success', 'The file was successfully deleted!');
        return redirect()->back();
    }
    public function guest_see($id)
    {
        $record = File::findOrFail($id);

        $record->guest_show = !$record->guest_show;
        $record->save();

        session()->flash('success', 'The File was successfully '.($record->guest_show ? 'Made Available To Guest':'Made Unavailable To Guest!'));
        return redirect()->back();
    }




}
