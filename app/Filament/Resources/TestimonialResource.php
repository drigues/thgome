<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Conteúdo';

    protected static ?string $navigationLabel = 'Testemunhos';

    protected static ?string $modelLabel = 'Testemunho';

    protected static ?string $pluralModelLabel = 'Testemunhos';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Nome')
                ->required()
                ->maxLength(255),
            TextInput::make('role')
                ->label('Cargo')
                ->maxLength(255),
            TextInput::make('company')
                ->label('Empresa')
                ->maxLength(255),
            Textarea::make('content')
                ->label('Testemunho')
                ->required()
                ->rows(4),
            FileUpload::make('avatar')
                ->label('Avatar')
                ->image()
                ->disk('public')
                ->directory('testimonials'),
            Select::make('rating')
                ->label('Avaliação')
                ->options([
                    1 => '1 Estrela',
                    2 => '2 Estrelas',
                    3 => '3 Estrelas',
                    4 => '4 Estrelas',
                    5 => '5 Estrelas',
                ])
                ->default(5),
            Toggle::make('is_active')
                ->label('Ativo')
                ->default(true),
            TextInput::make('sort_order')
                ->label('Ordem')
                ->numeric()
                ->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('company')
                    ->label('Empresa')
                    ->searchable(),
                TextColumn::make('rating')
                    ->label('Avaliação')
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Ordem')
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Ativo'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
