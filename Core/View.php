<?php

namespace Core;

class View
{
    protected static $sections = [];
    protected static $currentSection;

    public static function startSection($name)
    {
        self::$currentSection = $name;
        ob_start();
    }

    public static function endSection()
    {
        if (self::$currentSection) {
            self::$sections[self::$currentSection] = ob_get_clean();
            self::$currentSection = null;
        }
    }

    public static function yieldSection($name)
    {
        return self::$sections[$name] ?? '';
    }
}