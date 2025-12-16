<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import untuk relasi

class Inbox extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'agenda_number',
        'mail_number',
        'mail_date',
        'received_date',
        'sender',
        'intended_for',
        'subject',
        'summary',
        'file_path',
        'mail_category_id',
    ];

    /**
     * Get the mail category that owns the Inbox.
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        // Surat (Inbox) memiliki relasi BelongsTo (milik) satu kategori (MailCategory)
        return $this->belongsTo(MailCategory::class, 'mail_category_id');
    }
}
