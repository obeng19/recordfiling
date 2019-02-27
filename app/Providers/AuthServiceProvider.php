<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerAuthorization();
    }

    private function registerAuthorization() {
        // MODULE AUTHORIZATION
        Gate::define(
            'view-system-settings',
            '\App\Policies\AuthPolicy@view_system_settings'
        );
        Gate::define(
            'view-management-users',
            '\App\Policies\AuthPolicy@view_management_users'
        );
        Gate::define(
            'view-user-profile',
            '\App\Policies\AuthPolicy@view_user_profile'
        );
        Gate::define(
            'view-file',
            '\App\Policies\AuthPolicy@view_file'
        );
        Gate::define(
            'view-file-report',
            '\App\Policies\AuthPolicy@view_file_report'
        );
        Gate::define(
            'view-activity-monitor',
            '\App\Policies\AuthPolicy@view_activity_monitor'
        );
        Gate::define(
            'view-system-inventory',
            '\App\Policies\AuthPolicy@view_system_inventory'
        );
        Gate::define(
            'view-system-permission',
            '\App\Policies\AuthPolicy@view_system_permission'
        );











        Gate::define(
            'view-user-store',
            '\App\Policies\AuthPolicy@view_user_store'
        );
        Gate::define(
            'view-user-store-stock',
            '\App\Policies\AuthPolicy@view_user_store_stock'
        );
        Gate::define(
            'view-company-details',
            '\App\Policies\AuthPolicy@view_company_details'
        );

        Gate::define(
            'view-transactions-acc',
            '\App\Policies\AuthPolicy@view_transactions_acc'
        );



        //end couture expresss

        Gate::define(
            'view-hr-manager-admin',
            '\App\Policies\AuthPolicy@view_hr_manager_admin'
        );
        Gate::define(
            'view-hr-manager-staff',
            '\App\Policies\AuthPolicy@view_hr_manager_staff'
        );
        Gate::define(
            'view-project-manager',
            '\App\Policies\AuthPolicy@view_project_manager'
        );
        Gate::define(
            'view-project-staff-only',
            '\App\Policies\AuthPolicy@view_project_staff_only'
        );
        Gate::define(
            'view-payroll-staff-head',
            '\App\Policies\AuthPolicy@view_payroll_staff_head'
        );
        Gate::define(
            'view-account-manager',
            '\App\Policies\AuthPolicy@view_account_manager'
        );

        // PAYROLL AUTHORIZATION
        Gate::define(
            'view-payroll',
            '\App\Policies\AuthPolicy@view_payroll'
        );
        Gate::define(
            'view-payroll-accountant',
            '\App\Policies\AuthPolicy@view_payroll_accountant'
        );
        Gate::define(
            'view-payroll-staff-only',
            '\App\Policies\AuthPolicy@view_payroll_staff_only'
        );

        // INVENTORY MANAGER
        Gate::define('view-inventory-manager', '\App\Policies\AuthPolicy@view_inventory_manager');

        // EXPENSE MANAGER
        Gate::define('view-expense-manager', '\App\Policies\AuthPolicy@view_expense_manager');

        // INCOME MANAGER
        Gate::define('view-income-manager', '\App\Policies\AuthPolicy@view_income_manager');

    }
}
