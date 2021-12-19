<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Nullable;
use PhpParser\Node\Expr\FuncCall;
//use App\Models\assettype;

class assets extends Model
{
    use HasFactory;
    public function getTypeName(){
        return $this->belongsTo(assettype::class,'typeid');
    }
   
}
