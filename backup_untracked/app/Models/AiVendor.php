<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiVendor extends Model
{
    protected $fillable = ['key', 'name'];

    public function models()
    {
        return $this->hasMany(AiModel::class, 'ai_vendor_id');
    }
}
