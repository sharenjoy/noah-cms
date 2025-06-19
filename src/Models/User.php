<?php

namespace Sharenjoy\NoahCms\Models;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Sharenjoy\NoahCms\Actions\GenerateUserSeriesNumber;
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

    protected array $sort = [
        'created_at' => 'desc',
        'id' => 'desc',
    ];

    protected function formFields(): array
    {
        return [
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
                'password' => Section::make()->schema([
                    TextInput::make('password')
                        ->label(__('noah-cms::noah-cms.password'))
                        ->placeholder('********')
                        ->password()
                        ->dehydrated(fn($state) => !empty($state))
                        ->required(fn(Get $get): bool => !$get('id'))
                        ->rules(['min:8']),
                ])->visible(fn(Get $get): bool => !$get('id')),
            ],
            'right' => [
                'tags' => ['min' => 0, 'max' => 3, 'multiple' => true],
            ],
        ];
    }

    protected function tableFields(): array
    {
        return [
            'sn' => [],
            'name' => [],
            'email' => [],
            'roles' => [],
            'tags' => ['tagType' => 'user'],
            'created_at' => [],
            'updated_at' => [],
        ];
    }

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

    protected static function newFactory()
    {
        return \Sharenjoy\NoahCms\Database\Factories\UserFactory::new();
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

    public function scopeSuperAdmin($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'super_admin');
        });
    }

    public function scopeWithRolesHavingPermissions($query, array $permissions): Builder
    {
        // 查詢同時擁有所有指定權限的角色名稱
        $roles = Role::whereHas('permissions', function ($q) use ($permissions) {
            $q->whereIn('name', $permissions);
        }, '=', count($permissions))->pluck('name');

        // 查詢擁有上述角色的使用者
        return $query->whereHas('roles', function ($q) use ($roles) {
            $q->whereIn('name', $roles);
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
