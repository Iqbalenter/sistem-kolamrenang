<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'role',
        'status_membership',
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

    // Relationship dengan Booking
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Relationship dengan BookingKelas
    public function bookingKelas(): HasMany
    {
        return $this->hasMany(BookingKelas::class);
    }

    // Relationship dengan BookingSewaAlat
    public function bookingSewaAlat(): HasMany
    {
        return $this->hasMany(BookingSewaAlat::class);
    }

    // Method untuk check role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    // Method untuk check dan update status membership
    public function checkAndUpdateMembershipStatus(): void
    {
        // Hitung total booking dari semua jenis
        $totalBookingKolam = $this->bookings()->count();
        $totalBookingKelas = $this->bookingKelas()->count();
        $totalBookingSewaAlat = $this->bookingSewaAlat()->count();
        $totalBookings = $totalBookingKolam + $totalBookingKelas + $totalBookingSewaAlat;

        // Jika sudah 30x booking dan masih regular, update ke member
        if ($totalBookings >= 30 && $this->status_membership === 'regular') {
            $this->update(['status_membership' => 'member']);
        }
    }

    // Method untuk mendapatkan sisa booking yang diperlukan untuk menjadi member
    public function getRemainingBookingsForMember(): int
    {
        if ($this->status_membership === 'member') {
            return 0; // Sudah member
        }

        $totalBookingKolam = $this->bookings()->count();
        $totalBookingKelas = $this->bookingKelas()->count();
        $totalBookingSewaAlat = $this->bookingSewaAlat()->count();
        $totalBookings = $totalBookingKolam + $totalBookingKelas + $totalBookingSewaAlat;

        $remaining = 30 - $totalBookings;
        return max(0, $remaining);
    }

    // Method untuk mendapatkan label status membership
    public function getMembershipStatusLabelAttribute(): string
    {
        return match($this->status_membership) {
            'regular' => 'Regular',
            'member' => 'Member',
            default => 'Unknown'
        };
    }
}
