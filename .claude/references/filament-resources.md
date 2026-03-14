# Filament Resources — Código de Referência

## ProjectResource — Completo

```php
<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Category;
use App\Models\Project;
use Filament\Forms\Components\{
    Tabs, TextInput, Textarea, RichEditor, Select, Toggle,
    FileUpload, Repeater, ColorPicker, Grid, Section
};
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, IconColumn, ToggleColumn};
use Filament\Tables\Filters\{SelectFilter, TernaryFilter};
use Filament\Tables\Actions\{EditAction, DeleteAction, RestoreAction, ForceDeleteAction};
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Support\Str;
use Spatie\FilamentMediaLibrary\Forms\Components\SpatieMediaLibraryFileUpload;
use Spatie\FilamentMediaLibrary\Tables\Columns\SpatieMediaLibraryImageColumn;

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

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit'   => Pages\EditProject::route('/{record}/edit'),
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
```

---

## SettingResource — Custom Page

```php
<?php
namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\{Tabs, TextInput, Textarea, RichEditor, FileUpload, Section};
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Definições';
    protected static ?string $navigationGroup = 'Config';
    protected static string $view = 'filament.pages.settings';
    protected static ?int $navigationSort = 99;

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make()->tabs([
                Tabs\Tab::make('Geral')->schema([
                    TextInput::make('site_name')->label('Nome do Site')->required(),
                    TextInput::make('site_tagline')->label('Tagline'),
                    Textarea::make('site_description')->label('Descrição')->rows(3),
                    TextInput::make('contact_email')->label('Email de Contacto')->email(),
                    TextInput::make('contact_phone')->label('Telefone'),
                    TextInput::make('address')->label('Morada'),
                ]),
                Tabs\Tab::make('Redes Sociais')->schema([
                    TextInput::make('social_instagram')->label('Instagram')->url(),
                    TextInput::make('social_linkedin')->label('LinkedIn')->url(),
                    TextInput::make('social_github')->label('GitHub')->url(),
                    TextInput::make('social_behance')->label('Behance')->url(),
                    TextInput::make('social_dribbble')->label('Dribbble')->url(),
                ]),
                Tabs\Tab::make('Homepage')->schema([
                    TextInput::make('hero_title')->label('Título Hero'),
                    TextInput::make('hero_subtitle')->label('Subtítulo Hero'),
                    TextInput::make('hero_cta_text')->label('Texto do CTA'),
                ]),
                Tabs\Tab::make('Sobre')->schema([
                    TextInput::make('about_title')->label('Título da Página Sobre'),
                    RichEditor::make('about_text')->label('Texto Sobre')->toolbarButtons([
                        'bold', 'italic', 'h2', 'h3', 'bulletList', 'orderedList', 'link',
                    ]),
                    FileUpload::make('about_cv_url')
                        ->label('CV (PDF)')
                        ->disk('public')
                        ->directory('documents')
                        ->acceptedFileTypes(['application/pdf']),
                ]),
                Tabs\Tab::make('SEO')->schema([
                    TextInput::make('seo_title_suffix')->label('Sufixo do Title'),
                    TextInput::make('google_analytics_id')->label('Google Analytics ID')->placeholder('G-XXXXXXXXXX'),
                ]),
            ]),
        ])->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }
        Notification::make()->title('Definições guardadas!')->success()->send();
    }
}
```

**View blade** (`resources/views/filament/pages/settings.blade.php`):
```html
<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}
        <div class="mt-6">
            <x-filament::button type="submit">Guardar Definições</x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
```

---

## ContactMessageResource — Read-Only

```php
<?php
namespace App\Filament\Resources;

use App\Models\ContactMessage;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, IconColumn};
use Filament\Tables\Filters\TernaryFilter;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Contacto';
    protected static ?string $navigationLabel = 'Mensagens';
    protected static ?string $modelLabel = 'Mensagem';
    protected static ?string $pluralModelLabel = 'Mensagens';

    public static function getNavigationBadge(): ?string
    {
        return (string) ContactMessage::where('is_read', false)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string { return 'warning'; }

    public static function form(Form $form): Form
    {
        // Form vazio — apenas view via action
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('is_read')->label('Lida')->boolean(),
                TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('subject')->label('Assunto')->limit(40),
                TextColumn::make('message')->label('Mensagem')->limit(80)->wrap(),
                TextColumn::make('created_at')->label('Recebida')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_read')->label('Lida'),
            ])
            ->actions([
                Tables\Actions\Action::make('markRead')
                    ->label('Marcar Lida')
                    ->icon('heroicon-o-check')
                    ->action(fn (ContactMessage $record) => $record->update(['is_read' => true]))
                    ->visible(fn (ContactMessage $record) => !$record->is_read),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ContactMessageResource\Pages\ListContactMessages::route('/'),
        ];
    }

    public static function canCreate(): bool { return false; }
}
```
