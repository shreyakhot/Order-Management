<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;

class Setting extends Model
{
    use HasFactory, Filterable;

    protected $table = 'settings';

    protected $fillable = ['value'];

    public $timestamps = false;

    public $guarded = [];

    public static function findByKey($key)
    {
        return Setting::where('key', $key)->firstOrFail()->value;
    }

    public static function findTaxByKey($key)
    {
         $setting=Setting::where('key', $key)->first();
        if ($setting){
            return floatval($setting->value);
        }else{
            return 0;
        }
    }
}
