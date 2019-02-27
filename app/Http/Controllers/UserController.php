<?php
/**
 * Created by PhpStorm.
 * User: software
 * Date: 2/20/17
 * Time: 2:59 PM
 */

namespace app\Http\Controllers;


use App\AuditTrail;
use App\DataTables\UserDataTable;
use App\Hospital;
use App\Http\Controllers\Controller;
use App\ProfilePicture;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Knp\Snappy\Image;

class UserController extends Controller
{
    public function index(UserDataTable $table)
    {
        return $table->render('admin.user.index',[
            'page' => (object) ['title' => 'Users']

        ]);
    }

//    public function hos_get($id){
//        $sub=Hospital::query()->where('region_id',$id)->get();
//        $data=(object)['sub'=>$sub];
//        return response()->json($data) ;
//    }

    public function create($id)
    {
        $data = User::with('role')->findOrFail($id);
//        dd($data);
        return view('admin.user.create', [
            'data' => $data,
            'page' => (object) ['title' => 'New User']

        ]);
    }


    public function store(Request $request)
    {

        $_user = Auth::user();
        $this->validate($request, [
            'first_name'=> 'required',
            'last_name' => 'required',
            'official_phone' => 'required',
            'username'  => 'required|unique:users',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
            'role_id' => 'required',
            'confirm_password'  => 'required|same:password',
        ]);

        $inputs = $request->except(['_token']);
        $inputs['password']     = bcrypt($request['password']);
        $inputs['name'] = $inputs['first_name'].' '.$inputs['last_name'];
        $inputs['must_change_password'] = false;
        if($request->hasFile('avatar')){
            $image = $request->file('avatar');
            $path = public_path(). '/profile/';
            $filename = time() . '.' . $image->getClientOriginalExtension();
//            $upload_success = $image->storeAs( $filename, 'profile');
            $image->move($path, $filename);
            $inputs['avatar']=$filename;
            User::create($inputs);
        }else{
//            dd('hit1');
            User::create($inputs);
        };

        // create log entry
        $user = Auth::user();
        AuditTrail::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'region_id' => $user->region_id,
            'date' => Carbon::now()->toDateTimeString(),
            'activity' => $user->username.' created a new super admin user: '.$inputs['first_name']
        ]);
        $request->session()->flash('success', 'The User '.$inputs['first_name'].' '.$inputs['last_name'].' was successfully created!');
        return redirect()->back();
    }

    public function edit($id)
    {
        $data = User::with('role')->findOrFail($id);

        return view('admin.user.edit', [
            'data'   => $data,
            'page' => (object) ['title' => 'Edit User']

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
            'role_id' => 'required',
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
            'date' => Carbon::now()->toDateTimeString(),
            'activity' => $user->username.' updated a super admin user: '.$inputs['name']
        ]);

        $request->session()->flash('success', 'The User '.$inputs['first_name'].' '.$inputs['last_name'].' was successfully updated!');
        return redirect()->route('management.user.index');
    }

    public function lock($id)
    {
        $record = User::findOrFail($id);

        $record->is_locked = !$record->is_locked;
        $record->save();

        session()->flash('success', 'The user was successfully '.($record->is_locked ? 'locked':'unlocked!'));
        return redirect()->back();
    }

    public function delete($id) {
        $_user   = Auth::user();
        $record = User::findOrFail($id);

        $record->delete();

        //create log entry
        $user = Auth::user();
        AuditTrail::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'region_id' => $user->region_id,
            'date' => Carbon::now()->toDateTimeString(),
            'activity' => $user->username.' deleted a super admin user: '.$record->username
        ]);

        session()->flash('success', 'The user "'.$record->username.'" was successfully deleted!');
        return redirect()->back();
    }
}