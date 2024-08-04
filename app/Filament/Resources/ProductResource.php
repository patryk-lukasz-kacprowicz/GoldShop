<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()
                    ->tabs([
                        Tabs\Tab::make('Details')
                            ->schema([

                                Forms\Components\Grid::make(1)
                                    ->schema([
                                        Forms\Components\Select::make('patron_id')
                                            ->relationship('patron', 'name')
                                            ->columnSpanFull()
                                            ->preload()
                                            ->required(),

                                        Forms\Components\Select::make('type')
                                            ->options([
                                                'product' => 'Product',
                                                'digital' => 'Digital',
                                                'service' => 'Service',
                                            ])
                                            ->columnSpanFull()
                                            ->required(),
                                    ]),

                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->maxLength(255)
                                            ->required(),

                                        Forms\Components\TextInput::make('slug')
                                            ->maxLength(255)
                                            ->required(),
                                    ]),

                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('sku')
                                            ->default(function () {
                                                $sku = "66";
                                                $sku .= Str::random(9);

                                                return $sku;
                                            })
                                            ->required(),

                                        Forms\Components\TextInput::make('barcode')
                                            ->required(),
                                    ]),

                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('price')
                                            ->minValue(0.1)
                                            ->numeric()
                                            ->required(),

                                        Forms\Components\TextInput::make('vat')
                                            ->minValue(0.1)
                                            ->numeric()
                                            ->required(),

                                        Forms\Components\TextInput::make('discount')
                                            ->default(0)
                                            ->numeric()
                                            ->required(),
                                    ]),

                                Forms\Components\Grid::make(4)
                                    ->schema([
                                        Forms\Components\Toggle::make('is_active')
                                            ->nullable(),

                                        Forms\Components\Toggle::make('is_trend')
                                            ->nullable(),
                                    ]),

                            ]),
                        Tabs\Tab::make('Stock')
                            ->schema([
                                Forms\Components\Grid::make(1)
                                    ->schema([
                                        Forms\Components\Select::make('stock_id')
                                            ->relationship('stock', 'name')
                                            ->required(),
                                    ]),

                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Toggle::make('is_in_stock')
                                            ->nullable(),

                                        Forms\Components\Toggle::make('is_unlimited_stock')
                                            ->nullable(),
                                    ]),

                                Forms\Components\Grid::make(1)
                                    ->schema([
                                        Forms\Components\Toggle::make('has_max_cart')
                                            ->nullable()
                                            ->live(),
                                    ]),

                                Forms\Components\Grid::make()
                                    ->hidden(fn (Forms\Get $get) => !$get('has_max_cart'))
                                    ->schema([
                                        Forms\Components\TextInput::make('min_cart')
                                            ->numeric()
                                            ->required(fn (Forms\Get $get) => $get('has_max_cart') ?? false),

                                        Forms\Components\TextInput::make('max_cart')
                                            ->numeric()
                                            ->required(fn (Forms\Get $get) => $get('has_max_cart') ?? false),
                                    ]),

                                Forms\Components\Grid::make(1)
                                    ->schema([
                                        Forms\Components\Toggle::make('has_stock_alert')
                                            ->live()
                                            ->nullable(),
                                    ]),

                                Forms\Components\Grid::make()
                                    ->hidden(fn (Forms\Get $get) => !$get('has_stock_alert'))
                                    ->schema([
                                        Forms\Components\TextInput::make('min_stock')
                                            ->numeric()
                                            ->required(fn (Forms\Get $get) => $get('has_stock_alert') ?? false),

                                        Forms\Components\TextInput::make('max_stock')
                                            ->numeric()
                                            ->required(fn (Forms\Get $get) => $get('has_stock_alert') ?? false),
                                    ]),
                            ]),
                        Tabs\Tab::make('SEO')
                            ->schema([
                                Forms\Components\Grid::make(1)
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->directory('products')
                                            ->visibility('public')
                                            ->image()
                                            ->required(),

                                        SpatieMediaLibraryFileUpload::make('gallery')
                                            ->multiple()
                                            ->required(),

                                        Forms\Components\Select::make('category_id')
                                            ->relationship('category', 'title')
                                            ->live()
                                            ->preload()
                                            ->required(),
                                    ]),

                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('categories')
                                            ->relationship('categories', 'title')
                                            ->multiple()
                                            ->preload()
                                            ->required(),

                                        Forms\Components\Select::make('tags')
                                            ->relationship('tags', 'name')
                                            ->multiple()
                                            ->preload()
                                            ->required(),
                                    ]),

                                Forms\Components\Grid::make(1)
                                    ->schema([
                                        Forms\Components\MarkdownEditor::make('description')
                                            ->fileAttachmentsDirectory('products-attachments')
                                            ->required(),

                                        Forms\Components\MarkdownEditor::make('details')
                                            ->fileAttachmentsDirectory('products-attachments')
                                            ->required(),
                                    ]),
                            ]),
                    ])->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patron_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_shipped')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_in_stock')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_trend')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_max_cart')
                    ->boolean(),
                Tables\Columns\TextColumn::make('max_cart')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_stock_alert')
                    ->boolean(),
                Tables\Columns\TextColumn::make('min_stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_unlimited_stock')
                    ->boolean(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('barcode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vat')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('type')
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
