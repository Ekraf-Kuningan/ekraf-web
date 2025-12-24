<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Level;
use App\Models\SubSektor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PelakuEkrafRelationManager extends RelationManager
{
    protected static string $relationship = 'pelakuEkraf';

    protected static ?string $title = 'Informasi Pelaku Ekraf';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('business_name')
                    ->label('Business Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('business_status')
                    ->label('Business Status')
                    ->options([
                        'new' => 'New Business',
                        'existing' => 'Existing Business',
                    ])
                    ->required(),

                Forms\Components\Select::make('sub_sektor_id')
                    ->label('Sub Sektor')
                    ->relationship('subSektor', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Business Description')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('business_name')
            ->columns([
                Tables\Columns\TextColumn::make('business_name')
                    ->label('Business Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('business_status')
                    ->label('Status')
                    ->colors([
                        'success' => 'existing',
                        'warning' => 'new',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'New',
                        'existing' => 'Existing',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('subSektor.title')
                    ->label('Sub Sektor')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
