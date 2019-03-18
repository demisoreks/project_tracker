<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use Session;
use App\PtrExpense;
use App\PtrActivity;
use App\PtrProject;

class ExpensesController extends Controller
{
    public function index(PtrProject $project) {
        $expenses = PtrExpense::where('project_id', $project->id)->get();
        return view('expenses.index', compact('project', 'expenses'));
    }
    
    public function create(PtrProject $project) {
        return view('expenses.create', compact('project'));
    }
    
    public function store(PtrProject $project) {
        $input = Input::all();
        $error = "";
        $existing_expenses = PtrExpense::where('description', $input['description'])->where('project_id', $project->id);
        if ($existing_expenses->count() != 0) {
            $error .= "Expenses already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<strong>Oops!</strong><br />'.$error)
                    ->withInput();
        } else {
            $input['project_id'] = $project->id;
            $expense = PtrExpense::create($input);
            if ($expense) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                PtrActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Expense was created  for '.$project->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('projects.expenses.index', $project->slug())
                        ->with('success', '<strong>Successful!</strong><br />Expense has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<strong>Unknown error!</strong><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function edit(PtrProject $project, PtrExpense $expense) {
        return view('expenses.edit', compact('project', 'expense'));
    }
    
    public function update(PtrProject $project, PtrExpense $expense) {
        $input = Input::all();
        $error = "";
        $existing_expenses = PtrExpense::where('description', $input['description'])->where('project_id', $project->id)->where('id', '<>', $expense->id);
        if ($existing_expenses->count() != 0) {
            $error .= "Expense already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<strong>Oops!</strong><br />'.$error)
                    ->withInput();
        } else {
            if ($expense->update($input)) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                PtrActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Expense was uupdated for '.$project->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('projects.expenses.index', $project->slug())
                        ->with('success', '<strong>Successful!</strong><br />Expense has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<strong>Unknown error!</strong><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
}
