<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // ← добавляем, чтобы можно было массово присваивать роль
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ===================================================================
    // Отношение с ролью
    // ===================================================================
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // ===================================================================
    // Удобные методы для проверки роли (используем в Blade и контроллерах)
    // ===================================================================
    public function isModerator(): bool
    {
        return $this->role?->name === 'moderator';
    }

    public function isReader(): bool
    {
        return $this->role?->name === 'reader';
    }

    // Можно добавить универсальный метод, если ролей станет больше
    public function hasRole(string $roleName): bool
    {
        return $this->role?->name === $roleName;
    }
}
