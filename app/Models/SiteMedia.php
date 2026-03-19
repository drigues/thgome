<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SiteMedia extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['key', 'label'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('file')
            ->singleFile()
            ->useDisk('public')
            ->acceptsMimeTypes(['video/mp4', 'video/webm', 'video/ogg', 'image/jpeg', 'image/png', 'image/webp'])
            ->withResponsiveImages();

        $this->addMediaCollection('thumb')
            ->singleFile()
            ->useDisk('public');
    }

    public static function getUrl(string $key, string $collection = 'file'): ?string
    {
        $record = static::where('key', $key)->first();

        return $record?->getFirstMediaUrl($collection) ?: null;
    }

    public static function findOrCreate(string $key, string $label = ''): static
    {
        return static::firstOrCreate(['key' => $key], ['label' => $label]);
    }
}
