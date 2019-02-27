<?php

namespace App\Policies;

class AuthPolicy
{
    public function view_system_settings($user) {
        $role = $user->role->code;
        return $role === 'SYS_ADM' || $role === 'ADM_MAIN';
    }
    public function view_management_users($user) {
        $role = $user->role->code;
        return $role === 'SYS_ADM' || $role === 'ADM_MAIN';
    }
    public function view_user_profile($user) {
        $role = $user->role->code;
        return $role === 'USR_U' ;
    }

    public function view_file($user) {
        $role = $user->role->code;
        return $role === 'SYS_ADM' || $role === 'ADM_MAIN' || $role === 'USR_U';
    }

    public function view_activity_monitor($user) {
        $role = $user->role->code;
        return $role === 'SYS_ADM' || $role === 'ADM_MAIN';
    }
    public function view_system_inventory($user) {
        $role = $user->role->code;
        return $role === 'SYS_ADM' || $role === 'ADM_MAIN' || $role === 'USR_U';
    }
    public function view_file_report($user) {
        $role = $user->role->code;
        return $role === 'SYS_ADM' || $role === 'ADM_MAIN' || $role === 'USR_U';
    }
    public function view_system_permission($user) {
        $role = $user->role->code;
        return $role === 'SYS_ADM' || $role === 'ADM_MAIN' || $role === 'USR_U';
    }










    public function view_user_process($user) {
        $role = $user->role->code;
        return $role === 'USR_U'|| $role === 'USR_SPT' || $role === 'SYS_ADM' || $role==='WRK_SHP';
    }
    public function view_user_support($user) {
        $role = $user->role->code;
        return $role === 'USR_SPT';
    }
    public function view_user_store($user) {
        $role = $user->role->code;
        return $role === 'USR_SPT' || $role === 'USR_U' ||$role === 'SYS_ADM'|| $role==='WRK_SHP';
    }

    public function view_user_store_stock($user) {
        $role = $user->role->code;
        return $role === 'USR_SPT';
    }
    public function view_company_details($user) {
        $role = $user->role->code;
        return $role === 'SYS_ADM';
    }
    public function view_transactions_acc($user) {
        $role = $user->role->code;
        return $role === 'SYS_ADM' || $role === 'USR_SPT' ||$role==='WRK_SHP' ||$role==='USR_U';
    }




//end of couture Express

}
