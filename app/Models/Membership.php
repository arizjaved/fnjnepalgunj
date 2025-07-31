<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Membership extends Model
{
    protected $fillable = [
        'member_id',
        'full_name',
        'email',
        'phone',
        'citizenship_number',
        'date_of_birth',
        'gender',
        'address',
        'education',
        'experience_years',
        'current_workplace',
        'position',
        'membership_type',
        'status',
        'photo_path',
        'citizenship_copy_path',
        'experience_certificate_path',
        'approved_at',
        'expires_at',
        'rejection_reason',
        'approved_by',
        'category_id',
        'is_executive_committee',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'approved_at' => 'date',
        'expires_at' => 'date',
        'is_executive_committee' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::updating(function ($membership) {
            // Generate member ID when approved
            if ($membership->isDirty('status') && $membership->status === 'approved' && empty($membership->member_id)) {
                $membership->member_id = self::generateMemberId();
                $membership->approved_at = now();
                
                // Set expiry date based on membership type
                if ($membership->membership_type === 'life') {
                    $membership->expires_at = null; // Lifetime membership
                } else {
                    $membership->expires_at = now()->addYear(); // 1 year from approval
                }
            }
            
            // Check for expiry and update status
            if ($membership->expires_at && $membership->expires_at < now() && $membership->status === 'approved') {
                $membership->status = 'expired';
            }
        });
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MembershipCategory::class, 'category_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'approved')
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>=', now());
                    });
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
                    ->orWhere(function($q) {
                        $q->where('status', 'approved')
                          ->whereNotNull('expires_at')
                          ->where('expires_at', '<', now());
                    });
    }

    public function scopeExecutiveCommittee($query)
    {
        return $query->where('is_executive_committee', true);
    }

    public function scopeCentralMembers($query)
    {
        return $query->where('is_executive_committee', false);
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'approved' && 
               (!$this->expires_at || $this->expires_at >= now());
    }

    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at < now();
    }

    public function getDaysUntilExpiryAttribute()
    {
        if (!$this->expires_at) {
            return null; // Lifetime membership
        }
        
        return now()->diffInDays($this->expires_at, false);
    }

    public function getMembershipFeeAttribute()
    {
        $fees = [
            'associate' => 300,
            'regular' => 500,
            'life' => 10000,
        ];
        
        return $fees[$this->membership_type] ?? 0;
    }

    public function getMembershipTypeDisplayAttribute()
    {
        return $this->membership_type === 'life' ? 'Permanent' : ucfirst($this->membership_type);
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo_path) {
            return asset('storage/' . $this->photo_path);
        }
        return null;
    }

    public function getCitizenshipCopyUrlAttribute()
    {
        if ($this->citizenship_copy_path) {
            return asset('storage/' . $this->citizenship_copy_path);
        }
        return null;
    }

    public function getExperienceCertificateUrlAttribute()
    {
        if ($this->experience_certificate_path) {
            return asset('storage/' . $this->experience_certificate_path);
        }
        return null;
    }

    public static function generateMemberId()
    {
        $year = date('Y');
        $lastMember = self::where('member_id', 'like', "FNJ-{$year}-%")
                         ->orderBy('member_id', 'desc')
                         ->first();
        
        if ($lastMember) {
            $lastNumber = (int) substr($lastMember->member_id, -6);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return sprintf('FNJ-%s-%06d', $year, $newNumber);
    }

    public static function checkMembershipStatus($memberId)
    {
        $member = self::where('member_id', $memberId)->first();
        
        if (!$member) {
            return [
                'found' => false,
                'message' => 'सदस्य ID फेला परेन।'
            ];
        }
        
        $status = [
            'found' => true,
            'member_id' => $member->member_id,
            'full_name' => $member->full_name,
            'membership_type' => $member->membership_type,
            'status' => $member->status,
            'approved_at' => $member->approved_at,
            'expires_at' => $member->expires_at,
            'is_active' => $member->is_active,
            'days_until_expiry' => $member->days_until_expiry,
        ];
        
        if ($member->status === 'pending') {
            $status['message'] = 'तपाईंको सदस्यता आवेदन समीक्षाधीन छ।';
        } elseif ($member->status === 'rejected') {
            $status['message'] = 'तपाईंको सदस्यता आवेदन अस्वीकार गरिएको छ।';
        } elseif ($member->is_expired) {
            $status['message'] = 'तपाईंको सदस्यताको म्याद सकिएको छ।';
        } elseif ($member->is_active) {
            if ($member->membership_type === 'life') {
                $status['message'] = 'तपाईंको आजीवन सदस्यता सक्रिय छ।';
            } else {
                $daysLeft = $member->days_until_expiry;
                if ($daysLeft > 30) {
                    $status['message'] = 'तपाईंको सदस्यता सक्रिय छ।';
                } else {
                    $status['message'] = "तपाईंको सदस्यता {$daysLeft} दिनमा म्याद सकिने छ।";
                }
            }
        } else {
            $status['message'] = 'तपाईंको सदस्यता निष्क्रिय छ।';
        }
        
        return $status;
    }
}