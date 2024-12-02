<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Astrologer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'contact_no',
        'gender',
        'birth_date',
        'primary_skill',
        'all_skill',
        'language_known',
        'profile_image',
        'bio',
        'current_address',
        'city',
        'state',
        'country',
        'pincode',
        'experience_years',
        'qualification',
        'specialities',
        'languages',
        'certification_details',
        'chat_rate',
        'call_rate',
        'video_call_rate',
        'report_rate',
        'commission_rate',
        'availability_status',
        'website_link',
        'facebook_link',
        'instagram_link',
        'youtube_link',
        'linkedin_link',
        'is_verified',
        'verification_date',
        'verified_by',
        'rejection_reason',
        'account_status',
        'wallet_balance',
        'total_earned',
        'last_withdrawal',
        'is_active',
        'is_delete',
    ];

    protected $casts = [
        'birth_date' => 'datetime',
        'specialities' => 'json',
        'languages' => 'json',
        'verification_date' => 'datetime',
        'last_withdrawal' => 'datetime',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'is_delete' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
