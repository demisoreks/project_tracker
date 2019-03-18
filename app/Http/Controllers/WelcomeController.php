<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Lava;
use App\PtrProject;
use App\PtrUpdate;

class WelcomeController extends Controller
{
    public function index() {
        $project_status_data = Lava::DataTable();
        $project_status_data->addStringColumn('Overdue/On Track')
                ->addNumberColumn('Number of Projects');
        
        $project_status_data->addRow(["On Track", PtrProject::where('status', 'A')->where('end_date', '>=', date('Y-m-d'))->count()]);
        $project_status_data->addRow(["Overdue", PtrProject::where('status', 'A')->where('end_date', '<', date('Y-m-d'))->count()]);
        
        Lava::PieChart('PSD', $project_status_data, [
            'is3D' => true
        ]);
        
        $project_cost_data = Lava::DataTable();
        $project_cost_data->addStringColumn('Project');
        $project_cost_data->addNumberColumn('Budget');
        $project_cost_data->addNumberColumn('Spent');
        
        foreach (PtrProject::where('status', 'A')->get() as $project) {
            $project_cost_data->addRow([$project->name, $project->budget, PtrUpdate::where('project_id', $project->id)->sum('amount_spent')]);
        }
        
        Lava::ColumnChart('PCD', $project_cost_data, [
            
        ]);
        
        return view('index');
    }
    
    static function checkAccess() {
        if (!isset($_SESSION)) session_start();
        if (isset($_SESSION['halo_user'])) {
            return true;
        } else {
            return false;
        }
    }
}
