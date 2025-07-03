<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\UserResource\Pages;
use App\Filament\Superadmin\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('username')
                    ->maxLength(45),
                Forms\Components\TextInput::make('gender'),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->maxLength(20),
                Forms\Components\FileUpload::make('image')
                    ->image(),
                Forms\Components\TextInput::make('business_name')
                    ->maxLength(100),
                Forms\Components\TextInput::make('business_status'),
                Forms\Components\Select::make('level_id')
                    ->relationship('level', 'name')
                    ->required()
                    ->default(3),
                Forms\Components\TextInput::make('business_category_id')
                    ->numeric(),
                Forms\Components\TextInput::make('resetPasswordToken')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('resetPasswordTokenExpiry'),
                Forms\Components\DateTimePicker::make('verifiedAt'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('business_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('business_status'),
                Tables\Columns\TextColumn::make('level.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('business_category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('resetPasswordToken')
                    ->searchable(),
                Tables\Columns\TextColumn::make('resetPasswordTokenExpiry')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('verifiedAt')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
