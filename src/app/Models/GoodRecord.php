<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoodRecord extends Model
{
    protected $fillable = [
        'values',
        'upload_id',
    ];

    protected $casts = [
        'values' => 'array'
    ];

    public function fileUpload(): BelongsTo
    {
        return $this->belongsTo(FileUpload::class,'upload_id', 'id');
    }
}
