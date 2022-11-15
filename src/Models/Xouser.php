<?php

namespace Xoxoday\Fileupload\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xouser extends Model
{
    use HasFactory;
    protected $fillable = ['name','email','mobile','created_at','updated_at'];
}
