<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiModel extends Model
{
    protected $fillable = ['ai_vendor_id', 'key', 'name'];

    public function vendor()
    {
        return $this->belongsTo(AiVendor::class, 'ai_vendor_id');
    }
}
