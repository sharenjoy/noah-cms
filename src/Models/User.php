<?php

namespace Sharenjoy\NoahCms\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Sharenjoy\NoahCms\Models\Traits\HasTags;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser
{
    use CommonModelTrait;
    use HasFactory;
    use LogsActivity;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;
    use HasTags;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $translatable = [];

    protected array $formFields = [
        'left' => [
            'name' => [
                'required' => true,
                'rules' => ['required', 'string'],
            ],
            'email' => [
                'alias' => 'user_email',
                'required' => true,
                'rules' => ['required', 'email'],
            ],
            'password' => [
                'required' => true,
                'rules' => ['required', 'min:6'],
            ],
        ],
        'right' => [
            'tags' => ['min' => 0, 'max' => 3, 'multiple' => true],
        ],
    ];

    protected array $tableFields = [
        'name' => [],
        'email' => [],
        'roles' => [],
        'tags' => ['tagType' => 'user'],
        'created_at' => [],
        'updated_at' => [],
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), $this->getTaggableMorphName(), $this->getTaggableTableName())
            ->using($this->getPivotModelClassName())
            ->where('type', 'user')
            ->ordered();
    }

    /**
     * Determines if the User is a Super admin
     * @return null
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }

    /**
     * Determines if the User is a Super admin and creater
     * @return null
     */
    public function isSuperAdminAndCreater()
    {
        return $this->hasRole('super-admin') && Auth::user()->email == 'ronald.jian@gmail.com';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function canImpersonate()
    {
        return true;
    }
}
