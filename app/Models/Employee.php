<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Model
{
    use HasApiTokens;

    protected $table = 'employees';
    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'password',
        'status'
    ];



    public function setPhoneAttribute($value) // bu metod ile telefon numarasi sadece sayi formatinda alinir
    {
        // Sadece sayıları alıp telefon numarasını düzenlenir
        $this->attributes['phone'] = preg_replace('/\D/', '', $value);
    }


}
