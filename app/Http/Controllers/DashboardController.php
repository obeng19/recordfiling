<?php

namespace App\Http\Controllers;


use App\Activity;
use App\AuditTrail;
use App\Branch;
use App\Country;
use App\Eid;
use App\Event;
use App\Group;
use App\Inventory;
use App\Member;
use App\Project;
use App\Task;
use App\TimelineExtension;
use App\User;
use App\ViralLoad;
use Carbon\Carbon;
use Exception;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function goto_main_route()
    {

        return redirect()->route('app.dashboard');
    }

    public function index()
    {

        $_user = auth()->user();
        if($_user->is_locked===1){
            auth()->logout();
            return redirect()->route('login')->with('message','Account Is Blocked Contact The support Department');
        }else{
            //         force to change password
            if ($_user->must_change_password===0){
                return redirect()->route('app.password');
            }else{
                return view('dashboard');

            }


        }

    }

    public function donut(){
        $sub=ViralLoad::query() ->join('hospitals','hospitals.id','viral_loads.hospital_id')->selectRaw('hospitals.name as label, sum(viral_loads.no_tested) as value' )
            ->whereYear('viral_loads.created_at',date('Y'))
            ->groupBy('viral_loads.hospital_id','hospitals.name')->get();

        return response()->json($sub) ;
    }
    public function donut_(){
        $sub=Eid::query() ->join('hospitals','hospitals.id','eids.hospital_id')->selectRaw('hospitals.name as label, sum(eids.samples_in_waiting) as value' )
            ->whereYear('eids.created_at',date('Y'))
            ->groupBy('eids.hospital_id','hospitals.name')->get();

        return response()->json($sub) ;
    }
    public function inventory_(){
        $sub=Inventory::query() ->join('hospitals','hospitals.id','inventories.hospital_id')->selectRaw('hospitals.name as label, sum(inventories.stock_beginning_month) as value' )
            ->whereYear('inventories.created_at',date('Y'))
            ->groupBy('inventories.hospital_id','hospitals.name')->get();

        return response()->json($sub) ;
    }

    // reset password
    public function password(Request $request)
    {
        if (strtoupper($request->method()) == 'POST')
        {
            $_user = auth()->user();
            $this->validate($request, [
                'password1' => 'required|min:6',
                'password2' => 'required|min:6|same:password1'
            ]);

            if (!Hash::check($request['password1'], $_user->password)) {
                $_user->update([
                    'password' => bcrypt($request['password1']),
                    'must_change_password' => 1
                ]);
                $request->session()->flash('success', 'Password successfully CHANGED!');
                return redirect()->route('app.dashboard');
            }
            else {
                return redirect()->back()->withErrors(['error' => 'Password the same as Old Password!']);
            }
        }

        return view('change_password', [
            'page' => (object) ['title' => 'change password']
        ]);
    }

    public function get_user_photo()
    {
        $record = Auth::user();

        if (empty($record->picture))
        {
            $file= public_path('images/avatar.jpg');

            $headers = ['Content-Type: image/jpeg'];

            return Response::download($file, 'avatar.jpg', $headers);
        }
        $pic = Image::make($record->picture);
        $response = Response::make($pic->encode('jpeg'));
        $response->header('Content-Type', 'image/jpeg');
        return $response;
    }

    public function logout() {
        $_user = auth()->user();

        AuditTrail::create([
            'user_id' => $_user->id,
            'username' => $_user->username,
            'region_id' => $_user->region_id,
            'date' => Carbon::now()->toDateTimeString(),
            'activity' => $_user->username.' logged out '
        ]);

        auth()->logout();
        return redirect()->route('login');
    }
}