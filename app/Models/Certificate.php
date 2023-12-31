<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'issuer_ca_id',
        'issuer_name',
        'common_name',
        'name_value',
        'entry_timestamp',
        'not_before',
        'not_after',
        'serial_number',
    ];
}
