<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'username',
        'photo',
        'phone',
        'address',
        'role',
        'status',
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

    public function getUserImageAttribute()
    {
        // Determine the folder based on the user's role
        $folder = match ($this->role) {
            'admin' => 'admin_images',
            'instructor' => 'instructor_images',
            'user' => 'user_images',
            default => 'no_image',
        };

        // Check if the photo attribute is null or empty
        if (!$this->photo) {
            return asset('upload/no_image.jpg');
        }

        // Check if the file exists in the specified path
        if (!file_exists(public_path("upload/{$folder}/" . $this->photo))) {
            return asset('upload/no_image.jpg');
        }

        return asset("upload/{$folder}/" . $this->photo);
    } //end of getUserImageAttribute

    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }
}
