<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;

class UploadedDocument
{
    /**
     * Extensions allowed for general task/progress attachments.
     * Keep this whitelist explicit — do not switch to a blanket "file" rule.
     */
    public const ALLOWED_EXTENSIONS = [
        'pdf', 'zip', 'rar', '7z',
        'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx',
        'jpg', 'jpeg', 'png', 'webp',
    ];

    public const MAX_KILOBYTES = 102400; // 100MB

    /**
     * Validation rule string, e.g. for use as:
     * 'file' => UploadedDocument::rule()
     */
    public static function rule(): string
    {
        return 'file|max:' . self::MAX_KILOBYTES . '|mimes:' . implode(',', self::ALLOWED_EXTENSIONS);
    }

    /**
     * Store the file on the public disk under $directory and return
     * the metadata needed to persist alongside it.
     */
    public static function store(UploadedFile $file, string $directory): array
    {
        $path = $file->store($directory, 'public');

        return [
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime' => $file->getClientMimeType(),
        ];
    }
}
