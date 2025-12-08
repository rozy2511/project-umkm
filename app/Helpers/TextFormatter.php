<?php

namespace App\Helpers;

class TextFormatter
{
    public static function formatWaText($text)
    {
        if (empty($text)) return '';
        
        // Convert *teks* to <strong>teks</strong>
        $formatted = preg_replace('/\*(.*?)\*/', '<strong>$1</strong>', $text);
        
        // Convert _teks_ to <em>teks</em>
        $formatted = preg_replace('/_(.*?)_/', '<em>$1</em>', $formatted);
        
        // Convert newlines to <br>
        $formatted = nl2br($formatted);
        
        // Convert - item to list
        $formatted = preg_replace('/^- (.*)$/m', '• $1', $formatted);
        
        return $formatted;
    }
}