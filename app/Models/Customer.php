<?php

namespace App\Models;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'phone'];

    /**
     * Get the payments for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the latest payment of the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany('payment_date');
    }

    /**
     * Get the oldest payment of the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function oldestPayment()
    {
        return $this->hasOne(Payment::class)->oldestOfMany('payment_date');
    }

    /**
     * Get the highest payment of the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function highestPayment()
    {
        return $this->hasOne(Payment::class)->ofMany('amount', 'max');
    }

    /**
     * Get the lowest payment of the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lowestPayment()
    {
        return $this->hasOne(Payment::class)->ofMany('amount', 'min');
    }

    /**
     * Get the orders for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
