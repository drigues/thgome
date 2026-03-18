<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                    TextInput::make('intro_video_label')
                        ->label('Intro Video — Label')
                        ->helperText('Texto do badge acima do vídeo. Ex: Nice to meet you')
                        ->default('Nice to meet you'),
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
