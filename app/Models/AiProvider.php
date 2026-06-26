<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'name', 
    'ai_vendor_id', 
    'api_key', 
    'base_url', 
    'ai_model_id', 
    'is_default', 
    'web_search_enabled', 
    'system_prompt', 
    'temperature', 
    'presence_penalty', 
    'target_lies', 
    'description', 
    'creator'
])]
class AiProvider extends Model
{
    protected $casts = [
        'is_default' => 'boolean',
        'web_search_enabled' => 'boolean',
        'temperature' => 'float',
        'presence_penalty' => 'float',
        'target_lies' => 'array',
    ];

    public function vendor()
    {
        return $this->belongsTo(AiVendor::class, 'ai_vendor_id');
    }

    public function aiModel()
    {
        return $this->belongsTo(AiModel::class, 'ai_model_id');
    }
}
