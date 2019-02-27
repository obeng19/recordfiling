<?php

namespace App\DataTables;

use App\File;
use App\User;
use Yajra\DataTables\Services\DataTable;

class FileDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $user=auth()->user();
        return datatables($query)

            ->addColumn('cat_id',function ($row){
                return $row->category->name;
            })
            ->addColumn('subcat_id',function ($row){
                return $row->subcategory->name;
            })
            ->editColumn('docs',function ($row){
                if (!empty($row->docs)) {
                   return '<a title="download" href="' . route('file.docs.download', ['id' => $row->id]) . '">' . $row->docs . '</a>';
                }

            })
            ->editColumn('guest_show',function ($row){
                if ($row->guest_show=='0') {
                   return '<i class="fa fa-eye-slash fa-30x" style=" color: red" ></i>';
                }else{
                    return '<i class="fa fa-eye-slash fa-30x" style=" color: green" ></i>';
                }

            })
            ->addColumn('action', function ($row){
                if (auth()->user()->role_id==="3"){
                    return '<div class="btn-group">
 
                  <a title="DownLoad File" class="btn btn-default" href="' . route('file.docs.download', ['id' => $row->id]).'"><i class="fa fa-download" aria-hidden="true"></i></a> 
                  <a title="Edit Details" class="btn btn-primary" href="' . route('file.docs.edit', ['id' => $row->id]).'"><i class="fa fa-pencil" aria-hidden="true"></i></a> 
                  <a onclick="return confirm(\'Are you sure to delete this File?\')" title="Delete Details" class="btn btn-danger" href="' . route('file.docs.delete', ['id' => $row->id]).'"><i class="fa fa-trash-o" aria-hidden="true"></i></a> 
                  </div>';
                }else{
                    return '<div class="btn-group">
 
                  <a title="DownLoad File" class="btn btn-default" href="' . route('file.docs.download', ['id' => $row->id]).'"><i class="fa fa-download" aria-hidden="true"></i></a> 
                  <a title="Show File" class="btn btn-warning" href="' . route('file.docs.guest_see', ['id' => $row->id]).'"><i class="fa fa-eye" aria-hidden="true"></i></a> 
                  <a title="Edit Details" class="btn btn-primary" href="' . route('file.docs.edit', ['id' => $row->id]).'"><i class="fa fa-pencil" aria-hidden="true"></i></a> 
                  <a onclick="return confirm(\'Are you sure to delete this File?\')" title="Delete Details" class="btn btn-danger" href="' . route('file.docs.delete', ['id' => $row->id]).'"><i class="fa fa-trash-o" aria-hidden="true"></i></a> 
                  </div>';
                }

            })->rawColumns(['docs','action','guest_show']);



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
            $query = File::query()->where('region_id',$user->region_id);
        }elseif($user->role->code==='USR_U'){
            $query = File::query()->where('done_by',$user->id);
        }else{
            $query = File::query();
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
            ->addAction(['width' => '220'])
            ->parameters([
                'dom' => 'Bfrtip',
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
            'cat_id'=>['title'=>'Category'],
            'subcat_id'=>['title'=>'Subcategory'],
            'docs'=>['title'=>'Document'],
            'guest_show'=>['title'=>'Show To Guest']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'File_' . date('YmdHis');
    }
}
