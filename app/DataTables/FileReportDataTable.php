<?php

namespace App\DataTables;

use App\File;
use App\User;
use Yajra\DataTables\Services\DataTable;

class FileReportDataTable extends DataTable
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
            ->editColumn('docs',function ($row){
                if (!empty($row->docs)) {
                    return '<a title="download" href="' . route('file.docs.download', ['id' => $row->id]) . '">' . $row->docs . '</a>';
                }

            })
            ->addColumn('cat_id',function ($row){
                return $row->category->name;
            })
            ->addColumn('subcat_id',function ($row){
                return $row->subcategory->name;
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
        $cat_id = $this->request()->get('cat_id',0);
        $subcat_id = $this->request()->get('subcat_id',0);
        $from = $this->request()->get('from',0);
        $region_id = $this->request()->get('region_id',0);
        $report = $this->request()->get('report_type');
        $to = $this->request()->get('to',0);
        if($from !='' && $to!='')
        {
            $from = date('Y-m-d',strtotime($from));
            $to = date('Y-m-d',strtotime($to));

        }
        $user=auth()->user();
//        if($user->role->code==='SYS_ADM'){
            if(!empty($cat_id) && !empty($subcat_id) || !empty($to) && !empty($from) || !empty($region_id)){
                $query = File::query();
                switch($report){
                    case '2':
                        $query->where('cat_id',$cat_id)->where('subcat_id',$subcat_id)
                        ->whereBetween('created_at',[$from,$to]);
                        break;
                        case '1':
                            $query->whereBetween('created_at',[$from,$to]);
                        break;
                        case '3':
                            $query->where('region_id',$region_id);
                        break;
                }

            }else{
                $query=User::query()->where('id',0);

            }

//        }else{
//            $query=User::query()->where('id',0);

//        }
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
//            ->addAction(['width' => '150'])
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
            'cat_id'=>['title'=>'Category'],
            'subcat_id'=>['title'=>'Subcategory'],
            'docs'=>['title'=>'Document'],
//            'guest_show'=>['title'=>'Show To Guest']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'FileReport_' . date('YmdHis');
    }
}
