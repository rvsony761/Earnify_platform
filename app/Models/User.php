<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'referral_code',
        'referred_by',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
    // Relationship: Users referred by this user
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by', 'id');
    }

    // Relationship: User who referred this user
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by', 'id');
    }

    // Get total referrals count
    public function getTotalReferralsAttribute()
    {
        return $this->referrals()->count();
    }

    // Get referral link
    public function getReferralLinkAttribute()
    {
        return url('/register?ref=' . $this->referral_code);
    }

    // Update earnings based on referrals
    public function updateEarnings()
    {
        $this->earnings = $this->total_referrals * 100;
        $this->save();
    }
}

