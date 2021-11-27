<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageUrl extends Model
{
    protected $table='manage_urls';
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATEDTED_AT = 'updated_at';
    protected $user_id;
    protected $original_url;
    protected $unique_shortern_url;
    protected $url_type;
    protected $is_active;
    protected $expiration_time;

    protected $fillable = [
      'user_id',
      'original_url',
      'unique_shortern_url',
      'url_type',
      'is_active',
      'expiration_time',
  ];

}
