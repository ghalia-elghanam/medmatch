<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleType;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasMedia
{
    use HasFactory, HasRoles, InteractsWithMedia, LogsActivity, Notifiable;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'email',
                'ssn',
                'phone',
                'password',
                'result',
                'birth',
                'gender',
                'address',
            ]);
    }

    protected $fillable = [
        'name',
        'email',
        'ssn',
        'phone',
        'email_verified_at',
        'password',
        'result',
        'birth',
        'gender',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function birth(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y'),
            set: fn ($value) => Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d'),
        );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile')->singleFile();
        $this->addMediaCollection('rays');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $user = Auth::user();

        if ($panel->getId() === 'admin') {
            return $user->hasRole(RoleType::admin->value);
        } elseif ($panel->getId() === 'doctor') {
            return $user->hasRole(RoleType::doctor->value) || $user->hasRole(RoleType::radiologist->value);
        } else {
            return false;
        }
    }

    public function surgeries(): BelongsToMany
    {
        return $this->belongsToMany(Surgery::class, 'user_surgery')
            ->withTimestamps();
    }

    public function allergies(): BelongsToMany
    {
        return $this->belongsToMany(Allergy::class, 'user_allergy')
            ->withTimestamps();
    }

    public function medicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class, 'user_medicine')
            ->withTimestamps();
    }

    public function diseases(): BelongsToMany
    {
        return $this->belongsToMany(Disease::class, 'user_disease')
            ->withTimestamps();
    }
}
