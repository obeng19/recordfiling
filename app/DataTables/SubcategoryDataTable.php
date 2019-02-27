<?php

namespace App\DataTables;

use App\Category;
use App\Subcategory;
use App\User;
use Yajra\DataTables\Services\DataTable;

class SubcategoryDataTable extends DataTable
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
            ->addColumn('cat_id', function($row){return $row->category->name;})
            ->addColumn('description', function ($row){
                if(!$row->description){
                    return 'N/A';
                }else{
                    return $row->description;
                }
            })
            ->addColumn('action', function ($row){
                return '<div class="btn-group">
                  <a title="Edit Details" class="btn btn-primary" href="' . route('settings.subcategory.edit', ['id' => $row->id]).'"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a onclick="return confirm(\'Are you sure you want to delete this Record?\')" title="Delete Details" class="btn btn-sm btn-danger" href="' . route('settings.regions.delete', ['id' => $row->id]).'"><i class="fa fa-trash-o" aria-hidden="true"></i> </a>
                    ';
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
        $query = Subcategory::query();
        return $query;
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
            ->addAction(['width' => '127'])
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
            'cat_id'=>['title'=>'CATEGORY'],
            'name'=>['title'=>'SUBCATEGORY'],
            'description'=>['title'=>'DESCRIPTION'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Subcategory_' . date('YmdHis');
    }
}
