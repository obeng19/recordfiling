<?php

namespace App\Http\Controllers;

use App\AuditTrail;
use App\Category;
use App\File;
use App\Http\Requests;
use App\Role;
use App\Setup;
use App\Stock;
use App\Subcategory;
use App\Tools\SmsTools;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    public function getLogin() {
        $category=Category::all();
        $subcategory=Subcategory::all();
        return view('login',[
            'category'=>$category,
            'subcategory'=>$subcategory
        ]);
    }
    public function gettest() {
        $category=Category::all();
        $subcategory=Subcategory::all();
        return view('test',[
            'category'=>$category,
            'subcategory'=>$subcategory
        ]);
    }
    public function guest_table(Request $request ){
        $cat_id=$request->input('cat_id');
        $subcat_id=$request->input('subcat_id');
        return Datatables::of(File::query()->where('guest_show',1)
            ->where('cat_id',$cat_id)
            ->where('subcat_id',$subcat_id)
            ->get())
            ->addColumn('action',function ($row){
                return
                    '<a href="/guest/download/'.$row->id.'" class="btn btn-primary  waves-effect""><i class="fa fa-download" aria-hidden="true"></i></a>';
            })->toJson();
    }
    public function download($id)
    {
        $download = File::find($id);
        return response()->download(public_path() . "/document/" . $download->docs, $download->docs);
    }




    public function postLogin(Request $request) {
        //validate request
        $this->validate($request, [
            'login'    => 'required',
            'password' => 'required'
        ]);

        // get our login input
        $login = $request->input('login');

        // check login field
        $login_type = filter_var( $login, FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';

        // merge our login field into the request with either email or username as key
        $request->merge([ $login_type => $login ]);

        $credentials = $request->only($login_type, 'password');
        //check the user trying to login
        if(isset($credentials['username']) && !empty($credentials['username']))
            $user = User::where(['username' => $credentials['username']])->first();
//                ->whereHas('role', function($role) {
//                $role->whereIn('role_id', ['SYS_ADM','ADM_MAIN','USR_U']);
//            })
        else
            $user = User::where(['email' => $credentials['email']])->first();
//                ->whereHas('role', function($role) {
//                $role->whereIn('role_id', ['SYS_ADM', 'ADM_MAIN','USR_U']);
//            })

        if (!empty($user) && $user->is_locked===1) {
            //process locked user
            $request->session()->put('locked_user_id', $user->id);
            return redirect()->back()->withErrors('message','Account Is Deactivated');
        }

        if (Auth::attempt($credentials, false))
        {
            $user = Auth::user();
            if (empty($user->wrong_password_attempt_count)) {
                $user->wrong_password_attempt_count = 0;
            }
            if ($user->wrong_password_attempt_count > 0) {
                $user->wrong_password_attempt_count = 0;
                $user->save();
            }

            //update audit_trail
            AuditTrail::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'region_id' => $user->region_id,
                'date' => Carbon::now()->toDateTimeString(),
                'activity' => $user->name.' logged in '
            ]);

            //hard coded to be removed later
            if($user->username == 'darthur') {
                return redirect()->route('client.new_client');
            }

            if ($user->must_change_password===0) {
                //process change user password
//                dd('sam');
//                TODO: Change user password
//                abort(500, 'Your password has to be changed!');
                return redirect()->route('app.password');
            } else {
                return redirect()->route('app.dashboard');
            }
        } else {
            if (!empty($user)) {
                if (empty($user->wrong_password_attempt_count)) {
                    $user->wrong_password_attempt_count = 0;
                }
                $user->wrong_password_attempt_count++;
                //lock user password after 21 trial
                if ($user->wrong_password_attempt_count >= 30) {
                    $user->is_locked = true;
                }
                $user->save();
            }
            return Redirect::back()
                ->withInput($request->only('login', 'remember'))
                ->withErrors(['login' => Lang::get('auth.failed')]);
        }
    }
    public function land(){
        return view('welcome');
    }

    public function about_us(){
        return view('aboutus');
    }
    public function services(){
        return view('services');
    }
    public function gallery(){
        $pics=Stock::query()->where('status',0)->get();
        return view('gallery',[
            'pics'=>$pics
        ]);
    }
    public function contact_us(Request $request){

        if (strtoupper($request->method()) == 'POST')
        {


            $this->validate($request, [
                'full_name' => 'required',
                'email' => 'required',
                'message' => 'required'
            ]);


            $request->session()->flash('success', 'Message sent Successfully successfully!');
            return redirect()->back();
        }
        return view('contactus',[
        ]);
    }




    public function sign_up(Request $request){

        if (strtoupper($request->method()) == 'POST')
        {
            $user = auth()->user();
            $this->validate($request, [
                'first_name'=> 'required',
                'last_name' => 'required',
                'official_phone' => 'required',
                'username'  => 'required|unique:users',
                'email'     => 'required|email|unique:users',
                'password'  => 'required|min:6',
                'confirm_password'  => 'required|same:password',
            ]);


            $inputs= $request->all();
            $inputs = $request->except(['_token']);
            $inputs['password']= bcrypt($request['password']);
            $inputs['name'] = $inputs['first_name'].' '.$inputs['last_name'];
            $inputs['must_change_password'] = false;
            if($request->hasFile('avatar')){
                $image = $request->file('avatar');
                $path = public_path(). '/profile/';
                $filename = time() . '.' . $image->getClientOriginalExtension();
//            $upload_success = $image->storeAs( $filename, 'profile');
                $image->move($path, $filename);
                $inputs['avatar']=$filename;
               $use= User::create($inputs);
            }else{
                $use= User::create($inputs);
            };
            AuditTrail::create([
                'user_id' =>  $use->id,
                'username' =>  $use->username,
                'date' => Carbon::now()->toDateTimeString(),
                'activity' =>  $use->username.' created an new account'. $inputs['name']
            ]);

            $request->session()->flash('success', 'Account Created Successfully');
            return redirect()->back();
        }
        return view('signup');
    }
}
