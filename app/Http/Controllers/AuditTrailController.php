<?php

namespace App\Http\Controllers;

use App\AuditTrail;
use App\DataTables\AuditTrailDataTable;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    public function index(AuditTrailDataTable $dataTable){
        return $dataTable->render('audit.index',[
            'page' => (object) ['title' => 'System Audit']

        ]);
    }
}
