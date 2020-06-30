<?php

namespace App\Entities;

use App\Services\Dto\ManifestEntitiesDto;
use App\Utils\ValidateEntityInterface;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

/**
 * App\Entities\Epackage
 *
 * @property string $id
 * @property string $cmsId
 * @property string $cmsPackId
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Epackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Epackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Epackage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Epackage whereCmsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Epackage whereCmsPackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Epackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Epackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Epackage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $mpn
 * @property string $ean
 * @property string $productName
 * @property string $file_id
 * @property-read \App\Entities\File $file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Epackage whereEan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Epackage whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Epackage whereMpn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Epackage whereProductName($value)
 * @property string $brand_id
 * @property-read \App\Entities\Brand $brand
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Epackage whereBrandId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\EpackageRetailer[] $epackageRetailers
 * @property-read int|null $epackage_retailers_count
 */
class Epackage extends Model implements ValidateEntityInterface
{
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function change(SymfonyFile $uploadedFile, ManifestEntitiesDto $manifestEntitiesDto): Epackage
    {
        $this->file->setFile($uploadedFile);
        $manifestDto = $manifestEntitiesDto->manifestDto;

        $this->cmsId = $manifestDto->emsId;
        $this->cmsPackId = $manifestDto->packageId;
        $this->mpn = $manifestDto->mpn;
        $this->ean = $manifestDto->ean;
        $this->productName = $manifestDto->productName;

        $this->brand_id = $manifestEntitiesDto->brand->id;

        return $this;
    }

    public function rules(): array
    {
        $self = $this;

        return [
            'cmsPackId' => [
                'required',
                Rule::unique(self::class)->where(function ($query) use($self) {
                    return $query->where('cmsPackId', $self->cmsPackId)->where('cmsId', $self->cmsId);
                })->ignore($this->id)
            ],
            'ean' => [
                'required',
                Rule::unique(self::class)->where(function ($query) use($self) {
                    return $query->where('brand_id', $self->brand_id)->where('ean', $self->ean);
                })->ignore($this->id)
            ],
            'mpn' => [
                'required',
                Rule::unique(self::class)->where(function ($query) use($self) {
                    return $query->where('brand_id', $self->brand_id)->where('mpn', $self->mpn);
                })->ignore($this->id)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'cmsPackId.unique' => 'The packageID ":input" already used',
            'mpn.unique' => 'MPN ":input" already used',
            'ean.unique' => 'EAN ":input" already used',
        ];
    }

    public function toArray(): array
    {
        return parent::toArray();
    }

    public function getArchiveFile(): SymfonyFile
    {
        return $this->file->getFile();
    }

    public function getBrandName(): string
    {
        return $this->brand->name;
    }

    public function delete(): ?bool
    {
        if ($this->file instanceof File) {
            $this->file->delete();
        }

        return parent::delete();
    }

    public function epackageRetailers(): HasMany
    {
        return $this->hasMany(EpackageRetailer::class);
    }
}
