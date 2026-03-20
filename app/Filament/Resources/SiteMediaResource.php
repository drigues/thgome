<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteMediaResource\Pages;
use App\Models\SiteMedia;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteMediaResource extends Resource
{
    protected static ?string $model = SiteMedia::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationGroup = 'Config';

    protected static ?string $navigationLabel = 'Media do Site';

    protected static ?string $modelLabel = 'Media';

    protected static ?int $navigationSort = 98;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                TextInput::make('key')->disabled()->label('Identificador'),
                TextInput::make('label')->label('Descrição'),
            ]),
            Section::make('Ficheiros')->schema([
                SpatieMediaLibraryFileUpload::make('file')
                    ->collection('file')
                    ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg'])
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(102400)
                    ->label('Vídeo')
                    ->helperText('MP4 ou WebM. Máximo: 100MB.'),
                SpatieMediaLibraryFileUpload::make('thumb')
                    ->collection('thumb')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->disk('public')
                    ->visibility('public')
                    ->label('Thumbnail (imagem de capa)')
                    ->helperText('Imagem exibida antes do vídeo ser reproduzido. JPG, PNG ou WebP.'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')->label('Identificador')->searchable(),
                TextColumn::make('label')->label('Descrição'),
                TextColumn::make('updated_at')->label('Atualizado')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->actions([EditAction::make()])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteMedia::route('/'),
            'edit' => Pages\EditSiteMedia::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
