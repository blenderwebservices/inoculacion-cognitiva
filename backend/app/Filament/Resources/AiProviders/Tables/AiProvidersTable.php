<?php

namespace App\Filament\Resources\AiProviders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\AiProvider;

class AiProvidersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre del Agente')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('creator')
                    ->label('Creador')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('vendor.name')
                    ->label('Proveedor')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                TextColumn::make('aiModel.name')
                    ->label('Modelo')
                    ->searchable(),

                TextColumn::make('temperature')
                    ->label('Temp')
                    ->numeric(1)
                    ->sortable(),

                IconColumn::make('is_default')
                    ->label('Predeterminado')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('audit')
                    ->label('Auditar')
                    ->icon('heroicon-o-play')
                    ->color('info')
                    ->url(fn (AiProvider $record): string => '/admin/chat-sandbox?bot=' . $record->id),
                Action::make('default')
                    ->label('Marcar Default')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->hidden(fn (AiProvider $record): bool => $record->is_default)
                    ->action(function (AiProvider $record) {
                        AiProvider::where('id', '!=', $record->id)->update(['is_default' => false]);
                        $record->update(['is_default' => true]);
                    })
                    ->requiresConfirmation(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
