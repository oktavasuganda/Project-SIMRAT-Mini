<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Outbox extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'outboxes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'agenda_number',
        'mail_number',
        'mail_date',
        'intended_for',
        'subject',
        'summary',
        'file_path',
        'mail_category_id',
    ];

    /**
     * Get the mail category that owns the Outbox.
     */
    public function category(): BelongsTo
    {
        // Surat Keluar (Outbox) memiliki relasi BelongsTo (milik) satu kategori (MailCategory)
        return $this->belongsTo(MailCategory::class, 'mail_category_id');
    }
}
