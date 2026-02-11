<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'body',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getTemplate(string $name): ?self
    {
        return self::where('name', $name)->where('is_active', true)->first();
    }

    // Available placeholders for each template type
    public static function getPlaceholders(string $name): array
    {
        $placeholders = [
            'paper_status_changed' => [
                '{author_name}', '{paper_title}', '{old_status}', '{new_status}', '{dashboard_url}', '{copyright_form_url}', '{paper_format_url}', '{apc_url}'
            ],
            'paper_submitted_author' => [
                '{author_name}', '{paper_title}', '{authors}', '{submitted_date}', '{dashboard_url}'
            ],
            'paper_submitted_editor' => [
                '{paper_title}', '{authors}', '{submitter_name}', '{submitter_email}', '{submitted_date}', '{abstract}', '{review_url}'
            ],
            'reviewer_assigned' => [
                '{reviewer_name}', '{paper_title}', '{keywords}', '{abstract}', '{review_url}'
            ],
            'review_submitted' => [
                '{reviewer_name}', '{paper_title}', '{recommendation}', '{review_url}'
            ],
        ];

        return $placeholders[$name] ?? [];
    }
}