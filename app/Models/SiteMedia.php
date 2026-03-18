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
        $this->addMediaCollection('file')->singleFile();
    }

    public static function getUrl(string $key): ?string
    {
        $record = static::where('key', $key)->first();

        return $record?->getFirstMediaUrl('file') ?: null;
    }

    public static function findOrCreate(string $key, string $label = ''): static
    {
        return static::firstOrCreate(['key' => $key], ['label' => $label]);
    }
}
