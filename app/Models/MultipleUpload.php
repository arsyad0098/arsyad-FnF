<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultipleUpload extends Model
{
    protected $table = 'multipleuploads';
    protected $primaryKey = 'multipleuploads_id';
    
    protected $fillable = [
        'ref_table',
        'ref_id',
        'file_name',
        'file_path',
    ];
}