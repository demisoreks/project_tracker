<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Balping\HashSlug\HasHashSlug;

class PtrExpense extends Model
{
    use HasHashSlug;
    
    protected $table = "ptr_expenses";
    
    protected $guarded = [];
    
    public function project() {
        return $this->belongsTo('App\PtrProject');
    }
}
