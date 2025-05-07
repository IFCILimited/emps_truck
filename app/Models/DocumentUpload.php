<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentUpload extends Model
{
    protected $table = 'document_uploads';

    protected $fillable = [
        'app_id',
        'doc_id',
        'created_by',
        'updated_by',
        'file_name',
        'mime',
        'file_size',
        'uploaded_file',
        'remarks',
    ];
}