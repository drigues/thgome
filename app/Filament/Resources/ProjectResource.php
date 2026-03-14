<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Portfolio';

    protected static ?string $navigationLabel = 'Projetos';

    protected static ?string $modelLabel = 'Projeto';

    protected static ?string $pluralModelLabel = 'Projetos';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('Tabs')->tabs([

                Tabs\Tab::make('Geral')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabled(fn ($operation) => $operation === 'edit'),
                    ]),

                    Grid::make(3)->schema([
                        TextInput::make('client')->label('Cliente')->maxLength(255),
                        TextInput::make('url')
                            ->label('URL do Projeto')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://'),
                        TextInput::make('year')
                            ->label('Ano')
                            ->numeric()
                            ->minValue(2000)
                            ->maxValue(date('Y') + 1),
                    ]),

                    Select::make('category_id')
                        ->label('Categoria')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->nullable(),

                    Textarea::make('excerpt')
                        ->label('Resumo')
                        ->maxLength(255)
                        ->rows(2),

                    RichEditor::make('description')
                        ->label('Descrição Completa')
                        ->nullable()
                        ->toolbarButtons([
                            'bold', 'italic', 'underline', 'strike',
                            'h2', 'h3', 'bulletList', 'orderedList',
                            'link', 'blockquote', 'codeBlock',
                        ]),

                    Grid::make(3)->schema([
                        Toggle::make('is_featured')->label('Em Destaque')->default(false),
                        Toggle::make('is_active')->label('Ativo')->default(true),
                        TextInput::make('sort_order')->label('Ordem')->numeric()->default(0),
                    ]),
                ]),

                Tabs\Tab::make('Média')->schema([
                    Section::make('Capa')->schema([
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->collection('cover')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth(1200)
                            ->imageResizeTargetHeight(800)
                            ->disk('public')
                            ->visibility('public')
                            ->label('Imagem de Capa')
                            ->helperText('Dimensão recomendada: 1200x800px'),
                    ]),

                    Section::make('Galeria de Fotos')->schema([
                        SpatieMediaLibraryFileUpload::make('gallery')
                            ->collection('gallery')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->disk('public')
                            ->visibility('public')
                            ->label('Fotos')
                            ->helperText('Pode adicionar múltiplas fotos e reordená-las'),
                    ]),

                    Section::make('Vídeos Ficheiro')->schema([
                        SpatieMediaLibraryFileUpload::make('videos')
                            ->collection('videos')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg'])
                            ->multiple()
                            ->disk('public')
                            ->visibility('public')
                            ->label('Ficheiros de Vídeo')
                            ->helperText('Formatos suportados: MP4, WebM, OGG'),
                    ]),

                    Section::make('Vídeos Embed (YouTube / Vimeo)')->schema([
                        Repeater::make('video_embeds')
                            ->schema([
                                Select::make('platform')
                                    ->label('Plataforma')
                                    ->options([
                                        'youtube' => 'YouTube',
                                        'vimeo' => 'Vimeo',
                                    ])
                                    ->required(),
                                TextInput::make('embed_id')
                                    ->label('ID do Vídeo')
                                    ->helperText('YouTube: código após ?v= | Vimeo: número no URL')
                                    ->required(),
                                TextInput::make('title')
                                    ->label('Título (opcional)'),
                            ])
                            ->columns(3)
                            ->addActionLabel('Adicionar vídeo embed')
                            ->collapsible(),
                    ]),
                ]),

                Tabs\Tab::make('SEO')->schema([
                    TextInput::make('meta_title')
                        ->label('Meta Title')
                        ->maxLength(60)
                        ->helperText('Máximo 60 caracteres'),
                    Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->maxLength(160)
                        ->rows(3)
                        ->helperText('Máximo 160 caracteres'),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('cover')
                    ->collection('cover')
                    ->label('Capa')
                    ->width(60)
                    ->height(40),
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->badge()
                    ->sortable(),
                TextColumn::make('client')
                    ->label('Cliente')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('year')
                    ->label('Ano')
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->label('Destaque')
                    ->boolean(),
                ToggleColumn::make('is_active')
                    ->label('Ativo'),
                TextColumn::make('sort_order')
                    ->label('Ordem')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name'),
                TernaryFilter::make('is_featured')->label('Em Destaque'),
                TernaryFilter::make('is_active')->label('Ativo'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                \Illuminate\Database\Eloquent\SoftDeletingScope::class,
            ]);
    }
}
