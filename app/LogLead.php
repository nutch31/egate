<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogLead extends Model
{
    //
    protected $table = 'log_leads';
    protected $fillable = [
        'lead_id',
        'type',
        'status',
        'request',
        'result',
        'created_at',
        'updated_at'
    ];
}
