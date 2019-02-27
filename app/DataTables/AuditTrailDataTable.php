<?php

namespace App\DataTables;

use App\AuditTrail;
use App\User;
use Yajra\DataTables\Services\DataTable;

class AuditTrailDataTable extends DataTable
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
            ->addColumn('region_id', function($row){ return  $row->region->name;});
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
        if($user->role->code==='ADM_MAIN'){
            $query = AuditTrail::query()->where('region_id',$user->region_id);
        }else{
            $query = AuditTrail::query();
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
//                    ->addAction(['width' => '80px'])
                    ->parameters($this->getBuilderParameters()
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'user_id',
            'username',
            'region_id'=>['title'=>'Region'],
            'activity',
            'date',


        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'AuditTrail_' . date('YmdHis');
    }
}
