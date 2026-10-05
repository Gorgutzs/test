<?php

Class URLHelper{
    static function makeAbsoluteUrl($link, $baseUrl)
    {
        if (empty($link)) {
            return null;
        }

        // Bereits vollständige URL
        if (preg_match('/^https?:\/\//i', $link)) {
            return $link;
        }

        $base = parse_url($baseUrl);

        $scheme = $base['scheme'];
        $host = $base['host'];

             if (substr($link, 0, 1) === '?') {
            $basePath = $base['path'] ?? '/';
            return $scheme . '://' . $host . $basePath . $link; }

        // URL beginnt mit /
        if (substr($link, 0, 1) === '/') {
            return $scheme . '://' . $host . $link;
        }

        // Relativer Link
        $basePath = $base['path'] ?? '/';

        $directory = rtrim(dirname($basePath), '/');

        return $scheme . '://' . $host . $directory . '/' . $link;
    }
}