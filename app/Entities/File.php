<?php

namespace App\Entities;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Illuminate\Http\File as RealFile;
use Illuminate\Support\Facades\Storage;

/**
 * App\Entities\File
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File query()
 * @mixin \Eloquent
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\File whereUpdatedAt($value)
 * @property-read \App\Entities\Epackage|null $epackage
 */
class File extends Model
{
    protected $fillable = ['name'];

    public const FILE_STORAGE = 'epackages';

    private SymfonyFile $file;
    private bool $changed = false;

    public function getFile(): SymfonyFile
    {
        return $this->file;
    }

    public function isChanged(): bool
    {
        return $this->changed === true;
    }

    public function setFile(SymfonyFile $file): self
    {
        $this->file = $file;
        $this->changed = true;

        return $this;
    }

    public function epackage(): HasOne
    {
        return $this->hasOne(Epackage::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function($file) {
            self::getStorage()->delete($file->name);
        });

        static::retrieved(function($file) {
            if ($file->name) {
                $file->file = new RealFile(self::getStorage()->path($file->name));
            }
        });

        static::saving(function(File $file) {
            if ($file->isChanged()) {
                self::getStorage()->delete($file->name);
                $realFile = $file->getFile();
                $file->name = Str::random(40) . '.' . $realFile->guessExtension();
                self::getStorage()->putFileAs('', $realFile, $file->name);
            }
        });
    }

    private static function getStorage(): Filesystem
    {
        return Storage::disk(self::FILE_STORAGE);
    }
}
