<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use Redirect;
use Session;
use App\PtrComponent;
use App\PtrActivity;
use App\PtrProject;

class ComponentsController extends Controller
{
    public function index(PtrProject $project) {
        $components = PtrComponent::where('project_id', $project->id)->get();
        return view('components.index', compact('project', 'components'));
    }
    
    public function create(PtrProject $project) {
        return view('components.create', compact('project'));
    }
    
    public function store(PtrProject $project) {
        $input = Input::all();
        $error = "";
        $existing_components = PtrComponent::where('description', $input['description'])->where('project_id', $project->id);
        if ($existing_components->count() != 0) {
            $error .= "Component already exists.<br />";
        }
        if ($input['end_date'] < $input['start_date']) {
            $error .= "Specified end date is before the start date.<br />";
        }
        if ($input['start_date'] < $project->start_date || $input['start_date'] > $project->end_date) {
            $error .= "Component start date does not fall with project timeline.<br />";
        }
        if ($input['end_date'] < $project->start_date || $input['end_date'] > $project->end_date) {
            $error .= "Component end date does not fall with project timeline.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<strong>Oops!</strong><br />'.$error)
                    ->withInput();
        } else {
            $input['project_id'] = $project->id;
            $component = PtrComponent::create($input);
            if ($component) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                PtrActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Component was created  for '.$project->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('projects.components.index', $project->slug())
                        ->with('success', '<strong>Successful!</strong><br />Component has been created.');
            } else {
                return Redirect::back()
                        ->with('error', '<strong>Unknown error!</strong><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
    
    public function edit(PtrProject $project, PtrComponent $component) {
        return view('components.edit', compact('project', 'component'));
    }
    
    public function update(PtrProject $project, PtrComponent $component) {
        $input = Input::all();
        $error = "";
        $existing_components = PtrComponent::where('description', $input['description'])->where('project_id', $project->id)->where('id', '<>', $component->id);
        if ($existing_components->count() != 0) {
            $error .= "Component already exists.<br />";
        }
        if ($error != "") {
            return Redirect::back()
                    ->with('error', '<strong>Oops!</strong><br />'.$error)
                    ->withInput();
        } else {
            if ($component->update($input)) {
                if (!isset($_SESSION)) session_start();
                $halo_user = $_SESSION['halo_user'];
                PtrActivity::create([
                    'employee_id' => $halo_user->id,
                    'detail' => 'Component was uupdated for '.$project->name.'.',
                    'source_ip' => $_SERVER['REMOTE_ADDR']
                ]);
                return Redirect::route('projects.components.index', $project->slug())
                        ->with('success', '<strong>Successful!</strong><br />Component has been updated.');
            } else {
                return Redirect::back()
                        ->with('error', '<strong>Unknown error!</strong><br />Please contact administrator.')
                        ->withInput();
            }
        }
    }
}
