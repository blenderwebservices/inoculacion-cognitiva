<?php

namespace Database\Seeders;

use App\Models\AiModel;
use App\Models\AiVendor;
use Illuminate\Database\Seeder;

class AiSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = [
            'gemini' => [
                'name' => 'Google Gemini',
                'models' => [
                    'gemini-1.5-flash' => 'Gemini 1.5 Flash',
                    'gemini-2.5-flash' => 'Gemini 2.5 Flash',
                    'gemini-1.5-pro' => 'Gemini 1.5 Pro',
                    'gemini-2.5-pro' => 'Gemini 2.5 Pro',
                ],
            ],
            'openai' => [
                'name' => 'OpenAI',
                'models' => [
                    'gpt-4o' => 'GPT-4o',
                    'gpt-4o-mini' => 'GPT-4o Mini',
                ],
            ],
            'ollama' => [
                'name' => 'Ollama (Local)',
                'models' => [
                    'llama3' => 'Llama 3',
                    'mistral' => 'Mistral',
                ],
            ],
        ];

        foreach ($vendors as $key => $data) {
            $vendor = AiVendor::firstOrCreate(
                ['key' => $key],
                ['name' => $data['name']]
            );

            foreach ($data['models'] as $modelKey => $modelName) {
                AiModel::firstOrCreate(
                    [
                        'key' => $modelKey,
                        'ai_vendor_id' => $vendor->id,
                    ],
                    [
                        'name' => $modelName,
                    ]
                );
            }
        }
    }
}
