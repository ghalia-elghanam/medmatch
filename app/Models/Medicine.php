<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Medicine extends Model
{
    use HasTranslations,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name']);
    }

    public $translatable = ['name'];

    protected $fillable = [
        'name',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_medicine')
            ->withTimestamps();
    }

    public function restrictedMedicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class, 'restricted_medicines', 'medicine_id', 'restricted_medicine_id')
            ->withPivot('msg')
            ->withTimestamps();
    }
}
