<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    // ------------------------------
    // ATTRIBUTS
    // ------------------------------
    protected $fillable = [
        // Informations personnelles
        'first_name',
        'last_name',
        'name',                  // nom complet (peut être généré automatiquement)
        'email',
        'password',
        'sex',
        'birthdate',
        'national_id',
        'phone',
        'profile_photo_path',

        // Informations professionnelles / organisationnelles
        'centre_id',             // lien facultatif vers un centre
        'role',                  // rôle initial
        'status',                // actif / inactif
        'position',              // fonction ou poste
        'department',            // département ou service
        'hired_at',              // date d’affectation ou embauche
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate' => 'date',
        'hired_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ------------------------------
    // RELATIONS
    // ------------------------------
    public function centre()
    {
        return $this->belongsTo(Centre::class);
    }

    public function scoresEntered(): HasMany
    {
        return $this->hasMany(Score::class, 'entered_by');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    // ------------------------------
    // ROLE CHECKS
    // ------------------------------
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function isMinistere(): bool
    {
        return $this->hasRole('ministere');
    }

    public function isRegionalAdmin(): bool
    {
        return $this->hasRole('regional-admin');
    }

    public function isCentreAdmin(): bool
    {
        return $this->hasRole('centre-admin');
    }

    public function isJury(): bool
    {
        return $this->hasRole('jury');
    }

    public function isEtudiant(): bool
    {
        return $this->hasRole('etudiant');
    }

    public function isSecretaire(): bool
    {
        return $this->hasRole('secretaire');
    }

    public function isLecteur(): bool
    {
        return $this->hasRole('lecteur');
    }

    // ------------------------------
    // ACCESSEURS
    // ------------------------------
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    // ------------------------------
    // ADMINLTE INTEGRATION
    // ------------------------------
    public function adminlte_image(): string
    {
        return $this->profile_photo_path ? asset('storage/' . $this->profile_photo_path) : asset('images/logo.png');
    }

    public function adminlte_desc(): string
    {
        return match($this->role) {
            'super-admin'     => 'Super Administrateur',
            'ministere'       => 'Ministère',
            'regional-admin'  => 'Administrateur Régional',
            'centre-admin'    => 'Administrateur de Centre',
            'jury'            => 'Jury',
            'etudiant'        => 'Étudiant',
            'secretaire'      => 'Secrétaire',
            'lecteur'         => 'Lecteur',
            default           => 'Utilisateur',
        };
    }

    public function adminlte_profile_url(): string
    {
        return route('users.edit', $this->id);
    }

    // ------------------------------
    // AUTH
    // ------------------------------
    public function getAuthPassword(): string
    {
        return $this->password;
    }
}
