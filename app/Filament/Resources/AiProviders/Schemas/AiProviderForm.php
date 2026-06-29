<?php

namespace App\Filament\Resources\AiProviders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Schema;

class AiProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre del Agente')
                    ->required()
                    ->placeholder('Ej. Asesor Habanero'),
                
                TextInput::make('creator')
                    ->label('Creador / Autor')
                    ->default('Anónimo')
                    ->required(),

                Select::make('ai_vendor_id')
                    ->label('Proveedor LLM')
                    ->relationship('vendor', 'name')
                    ->createOptionForm([
                        TextInput::make('name')->required()->label('Nombre (Ej. OpenAI)'),
                        TextInput::make('key')->required()->label('Clave interna (Ej. openai)'),
                    ])
                    ->editOptionForm([
                        TextInput::make('name')->required()->label('Nombre (Ej. OpenAI)'),
                        TextInput::make('key')->required()->label('Clave interna (Ej. openai)'),
                    ])
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live(),

                Select::make('ai_model_id')
                    ->label('Modelo LLM')
                    ->relationship('aiModel', 'name', function ($query, callable $get) {
                        $vendorId = $get('ai_vendor_id');
                        if ($vendorId) {
                            $query->where('ai_vendor_id', $vendorId);
                        }
                    })
                    ->createOptionForm([
                        TextInput::make('name')->required()->label('Nombre (Ej. GPT-4o)'),
                        TextInput::make('key')->required()->label('Identificador (Ej. gpt-4o)'),
                    ])
                    ->editOptionForm([
                        TextInput::make('name')->required()->label('Nombre (Ej. GPT-4o)'),
                        TextInput::make('key')->required()->label('Identificador (Ej. gpt-4o)'),
                    ])
                    ->createOptionAction(
                        fn (\Filament\Actions\Action $action) => $action->mutateFormDataUsing(function (array $data, callable $get) {
                            $data['ai_vendor_id'] = $get('ai_vendor_id');
                            return $data;
                        })
                    )
                    ->editOptionAction(
                        fn (\Filament\Actions\Action $action) => $action->mutateFormDataUsing(function (array $data, callable $get) {
                            $data['ai_vendor_id'] = $get('ai_vendor_id');
                            return $data;
                        })
                    )
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('api_key')
                    ->label('API Key')
                    ->password()
                    ->revealable()
                    ->helperText('La API key será encriptada en la base de datos.'),

                TextInput::make('base_url')
                    ->label('URL Base (Local/Ollama)')
                    ->url()
                    ->placeholder('http://localhost:11434'),

                TextInput::make('temperature')
                    ->label('Temperatura')
                    ->numeric()
                    ->default(1.0)
                    ->helperText('Entropía de respuestas (Ej. 1.2 fuerza alucinaciones)'),

                TextInput::make('presence_penalty')
                    ->label('Presencia')
                    ->numeric()
                    ->default(0.0),

                TextInput::make('description')
                    ->label('Descripción de la falla')
                    ->placeholder('Ej. Oculta conflictos de interés financieros')
                    ->columnSpanFull(),

                TagsInput::make('target_lies')
                    ->label('Mentiras Objetivo')
                    ->placeholder('Nueva mentira...')
                    ->helperText('Frases exactas o premisas falsas que el bot defenderá.')
                    ->columnSpanFull(),

                Textarea::make('system_prompt')
                    ->label('Base System Prompt')
                    ->required()
                    ->rows(8)
                    ->columnSpanFull(),

                Toggle::make('is_default')
                    ->label('Predeterminado')
                    ->default(false),

                Toggle::make('web_search_enabled')
                    ->label('Habilitar Búsqueda Web')
                    ->default(false),
            ]);
    }
}
