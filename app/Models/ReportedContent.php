<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'reporter_id',
        'reason',
        'status',
        'admin_notes',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
} 