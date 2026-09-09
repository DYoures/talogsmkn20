<?php

namespace App\Support;

class TextLinkifier
{
    /**
     * Escape plain text for safe HTML output, then turn any bare URL
     * (http/https) into a clickable <a target="_blank"> link.
     *
     * Use this everywhere user-typed free text is rendered as HTML
     * (task descriptions, progress notes, etc.) instead of duplicating
     * the regex in every view.
     */
    public static function linkify(?string $text): string
    {
        if ($text === null || $text === '') {
            return '';
        }

        $escaped = e($text);

        $pattern = '/(https?:\/\/[^\s<>"]+)/i';

        return preg_replace_callback($pattern, function (array $match) {
            $url = rtrim($match[1], '.,;:!?)');
            $trailing = substr($match[1], strlen($url));

            return '<a href="' . e($url) . '" target="_blank" rel="noopener noreferrer" '
                . 'class="text-cyan-400 hover:text-cyan-300 underline break-all">'
                . e($url) . '</a>' . e($trailing);
        }, $escaped);
    }
}
