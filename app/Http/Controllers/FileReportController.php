<?php

namespace App\Http\Controllers;

use App\DataTables\FileReportDataTable;
use Illuminate\Http\Request;

class FileReportController extends Controller
{
    public function index(FileReportDataTable $dataTable){
        return $dataTable->render('report.file',[
            'page' => (object) ['title' => 'File Report']
        ]);
    }
}
