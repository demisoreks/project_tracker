<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Balping\HashSlug\HasHashSlug;

class PtrProject extends Model
{
    use HasHashSlug;
    
    protected $table = "ptr_projects";
    
    protected $guarded = [];
    
    public function vendor() {
        return $this->belongsTo('App\PtrVendor');
    }
    
    public function components() {
        return $this->hasMany('App\PtrComponent');
    }
    
    public function expenses() {
        return $this->hasMany('App\PtrExpense');
    }
    
    public function updates() {
        return $this->hasMany('App\PtrUpdate');
    }
}
