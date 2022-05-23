<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  \Illuminate\Database\Eloquent\Casts\Attribute;
/**
 * Product Model
 */
class Product extends Model
{
    use HasFactory;


    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'image',
        'active',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Interact with the Product first name.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function active(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value == 0 ? 'unActive' : 'Active',
        );
    }


    public function getPrice()
    {
        if (auth()->user()->type == UserType::Gold->value) {

            return currency($this->price - ($this->price * (10 / 100)));

        } elseif (auth()->user()->type == UserType::Silver->value)
         {

            return currency($this->price - ($this->price * (5 / 100)));
        }
        return currency($this->price);
    }
}
