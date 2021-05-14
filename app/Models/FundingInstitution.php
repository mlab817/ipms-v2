<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\HasUuid;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FundingInstitution extends Model
{
    use HasFactory;
    use Sluggable;
    use Auditable;

    protected $fillable = [
        'name',
        'description',
        'funding_source_id',
    ];

    public function funding_source(): BelongsTo
    {
        return $this->belongsTo(FundingSource::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
