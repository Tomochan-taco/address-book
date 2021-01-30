<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public function scopeSearch($query) {

        $request = request();

        $query->when($request->name, function($q, $name) {
            $q->where('name', 'LIKE', '%' . $name . '%');
        })
        ->when($request->zip_code, function($q, $zip_code) {
            $q->where('zip_code', 'LIKE', '%' . $zip_code . '%');
        })
        ->when($request->prefecture, function($q, $prefecture) {
            $q->where('prefecture', 'LIKE', '%' . $prefecture . '%');
        })
        ->when($request->city, function($q, $city) {
            $q->where('city', 'LIKE', '%' . $city . '%');
        })
        ->when($request->address, function($q, $address) {
            $q->where('address', 'LIKE', '%' . $address . '%');
        })
        ->when($request->phone_number, function($q, $phone_number) {
            $q->where('phone_number', 'LIKE', '%' . $phone_number . '%');
        });

    }
}
