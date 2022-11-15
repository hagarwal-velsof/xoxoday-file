<?php

namespace Xoxoday\Fileupload\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xofile extends Model
{
    use HasFactory;
    protected $fillable = ['xouser_id','response_no','file_name','path','otp','status','created_at','updated_at'];
}
