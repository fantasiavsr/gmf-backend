<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'document_id',
        'user_id',
        'certificate_no',
        'welder_name',
        'welder_identification_no',
        'test_date',
        'data',
    ];

    protected function casts(): array
    {
        return [
            'test_date' => 'date',
            'data' => 'array',
        ];
    }

    /**
     * Get the document associated with this certificate.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Get the user (certificate owner) associated with this certificate.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
