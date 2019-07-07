<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    //
    const LANDING_PAGE_SYSTEM   = 'landing page';
    const PHONE_SYSTEM          = 'pbx';
    const TYPE_SUBMITTED        = 'submitted';
    const TYPE_ANSWERED         = 'answered';
    const TYPE_MISSED_CALL      = 'missed_call';
    const NOT_CONTENT = [
        'token',
        'channel_id',
        'name',
        'email',
        'phone',
        'ip_address',
        'page_url'
    ];
    const EMAIL_FROM = 'nutnutnutnutnutnutnutnutnutnut@gmail.com';

    protected $table = 'leads';
    protected $fillable = [
        'channel_id',
        'type',
        'submitted_date_time',
        'form_name',
        'form_email',
        'form_phone',
        'form_content',
        'form_ip_address',
        'form_page_url',
        'call_phone',
        'call_status',
        'call_recording_url',
        'call_forward_phone',
        'is_duplicated',
        'parent_id',
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function log_lead()
    {
        return $this->hasOne(LogLead::class, 'lead_id', 'id');
    }
}
