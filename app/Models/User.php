<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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
    ];

    public function hasPermissionTo($permission)
    {
        $permissions = ['mail_setting', 'dynamic_page', 'profile setting'];

        return in_array($permission, $permissions);
    }

    /**
     * Get all social links of user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socialmedia()
    {
        return $this->hasMany(ProducerSocialmedia::class, 'user_id');
    }

    // Define a relationship to UserMembership
    public function memberships()
    {
        return $this->hasMany(UserMembership::class);
    }

    /**
     * Check Auth User Membership
     * @return Membership
     */
    public function hasMembership()
    {
        // Retrieve the membership and check if the end date is in the future or today
        $membership = UserMembership::where([
            'user_id' => auth()->user()->id,
            'status' => 'active',
            'cancel' => 0,
        ])->orderBy('id', 'desc')->first();
        return $membership;
    }


    //For paid unpaid user check methode 
    public function ifMembership()
    {

        $membership = UserMembership::where([
            'user_id' => $this->id,
            'status' => 'active',
            'cancel' => 0,
        ])->orderBy('id', 'desc')->first();
        return $membership;
    }

    /**
     * Followed Check
     * @param $id
     * @return bool
     */
    public function isFollowing($id)
    {
        $exist = Follower::where('follower_id', auth()->user()->id)->where('user_id', $id)->first();
        if ($exist) {
            return true;
        }
        return false;
    }

    /**
     * Get the users that the user is following.
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    /**
     * Get the users that follow the user.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    /**
     * Get all Melodies of user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function melodies()
    {
        return $this->hasMany(Melody::class, 'user_id');
    }

    /**
     * Get all Pack of user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function packs()
    {
        return $this->hasMany(Pack::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id'); 
    }

}
