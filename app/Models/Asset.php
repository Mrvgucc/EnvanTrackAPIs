<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'asset';

    protected $fillable = [
        'id',
        'name',
        'category_id', // foreign key
        'registered_personal', // foreign key
        'usage_status'
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function($asset){
            if(is_null($asset->registered_personal)){ // kayitli bir personel yoksa kullanim durumu inactive olacak
                $asset->usage_status = 'inactive';
            }
            else{
                $asset->usage_status = 'active'; // personel atamasi yoksa active yap
            }


        });
    }

    public function registered_personal()
    {
        return $this->belongsTo(Employee::class, 'registered_personal');
    }

    public function category_id()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
