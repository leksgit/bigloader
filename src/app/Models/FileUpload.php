<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FileUpload extends Model
{

    protected $fillable = [
        'file_path',
        'status',
        'success_count',
        'error_count',
    ];

    public function goodRecords(): HasMany
    {
        return$this->hasMany(GoodRecord::class, 'upload_id');
    }
    public function errorRecords(): HasMany
    {
        return$this->hasMany(ErrorRecord::class, 'upload_id');
    }
}
