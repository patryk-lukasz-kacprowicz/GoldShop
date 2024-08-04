<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Filament\Resources\StockResource\RelationManagers;
use App\Models\Stock;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Card::make('General')
                    ->schema([
                        Forms\Components\Toggle::make('active')
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\Select::make('country_id')
                            ->relationship('country', 'name')
                            ->live()
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\Select::make('city_id')
                            ->relationship('city', 'name', function (Builder $query, Forms\Get $get) {
                                return $query->where('country_id', $get('country_id'));
                            })
                            ->preload()
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->columnSpanFull()
                            ->maxLength(255),
                    ]),

                Forms\Components\Card::make('Staff')
                    ->schema([
                        Forms\Components\Select::make('manager_id')
                            ->relationship('manager', 'name')
                            ->live()
                            ->columnSpanFull()
                            ->required(),

                        Forms\Components\Select::make('workers')
                            ->relationship('workers', 'users.name')
                            ->multiple()
                            ->hidden(function (Forms\Get $get) {
                                return !$get('manager_id');
                            })
                            ->options(function (Forms\Get $get) {
                                return User::query()
                                    ->whereNot('id', $get('manager_id'))
                                    ->pluck('name', 'id');
                            })
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('country.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListStocks::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit' => Pages\EditStock::route('/{record}/edit'),
        ];
    }
}
