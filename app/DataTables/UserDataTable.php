<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('name', function($row){return $row->first_name .' '. $row->last_name;})
            ->addColumn('role_id', function($row){return $row->role->name;})
            ->addColumn('region_id', function($row){ return  $row->region->name;})
            ->addColumn('last_login_date', function($row){
                return $row->last_login_date != null ? $row->last_login_date : 'NEVER';
            })
            ->addColumn('is_locked', function($row){
                if($row->is_locked===0){
                    return 'Active';
                }else{
                    return 'Locked';
                }
            })
            ->addColumn('action', function ($row){
                return '<div class="btn-group">
                    <a title="Edit Details" class="btn btn-primary" href="' . route('settings.management.user.edit', ['id' => $row->id]).'"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a title="'.($row->is_locked ? "Unlock" : "Lock").' User" class="btn btn-sm btn-warning" href="' . route('settings.management.user.lock', ['id'=>$row->id]) . '"
                    onclick="return confirm(\'Do you want to '.($row->is_locked ? "unlock" : "lock").' this user?\')"><i class="fa fa-key"></i></a>
                    <a onclick="return confirm(\'Are you sure to delete this Record?\')" title="Delete" class="btn btn-sm btn-danger" href="' . route('settings.management.user.delete', ['id' => $row->id]).'"><i class="fa fa-trash-o" aria-hidden="true"></i> </a>
                    </div>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $user=auth()->user();
        if($user->role->code==='ADM_MAIN') {
            $query = User::query()->where('region_id', $user->region_id);
        }
        else{
            $query = User::query();
        }
        return $this->applyScopes($query);

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '150'])
            ->parameters([
                'dom' => 'Blfrtip',
                'buttons' => ['csv', 'excel', 'print', 'reload'],
                'order' => [[0, 'asc']]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name'=>['title'=>'Full Name'],
            'username',
            'region_id'=>['title'=>'Region'],
            'official_phone'=>['title'=>'Phone Number'],
            'role_id'=>['title'=>'Role'],
            'is_locked'=>['title'=>'Status'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
