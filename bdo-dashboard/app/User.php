<?php

namespace App;

use App\Models\Cart;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'referred_by',
        'provider_id',
        'user_type',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'avatar',
        'avatar_original',
        'address',
        'country',
        'city',
        'postal_code',
        'phone',
        'verification_code',
        'balance',
        'referral_code',
        'customer_package_id',
        'remaining_uploads',
        'distributor_id',
        'is_merchant',
        'status',
        'bdo_id',
        'is_distributor',
    ];

    use Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function distributors()
    {
        return $this->hasMany(User::class, 'bdo_id');
    }

    public function bdo()
    {
        return $this->belongsTo(User::class, 'bdo_id');
    }
    public function scopePublished($query)
    {
        return $query->where('status','1');
    }




    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    public function affiliate_user()
    {
        return $this->hasOne(AffiliateUser::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class)->orderBy('created_at', 'desc');
    }

    public function club_point()
    {
        return $this->hasOne(ClubPoint::class);
    }
    public function customer_package()
    {
        return $this->belongsTo(CustomerPackage::class);
    }

    public function customer_products()
    {
        return $this->hasMany(CustomerProduct::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
