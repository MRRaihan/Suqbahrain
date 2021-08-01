<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id', 'seller_id','product_id','variation','price','tax','shipping_cost','quantity','payment_status','delivery_status','shipping_type','pickup_point_id','product_referral_code','created_at','updated_at','category_id','profit', 'club_point', 'user_id'
    ];
    
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function pickup_point()
    {
        return $this->belongsTo(PickupPoint::class);
    }

    public function refund_request()
    {
        return $this->hasOne(RefundRequest::class);
    }
    
     public function sellers(){
        return $this->belongsToMany(Seller::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
