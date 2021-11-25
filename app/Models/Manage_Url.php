<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manage_Url extends Model
{
    protected $table='manage_urls';
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATEDTED_AT = 'updated_at';
    protected $original_url;
    protected $unique_shortern_url;
    protected $is_active;
    protected $expiration_time;

    protected $fillable = [
      'original_url',
      'unique_shortern_url',
      'is_active',
      'expiration_time',
  ];

    public function checkAuthentication($original_url, $unique_shortern_url, $is_active, $expiration_time)
    {
      $data=array('original_url'=>$original_url, 'unique_shortern_url'=>$unique_shortern_url, 'is_active'=>$is_active, 'expiration_time'=>$expiration_time);
      DB::table('manage_urls')->insert($data);
    }
}
