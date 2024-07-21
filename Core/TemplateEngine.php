<?php

namespace Core;

class TemplateEngine
{
    protected $layout;
    protected $sections = [];
    protected $currentSection;

    public function __construct($layout = null)
    {
        $this->layout = $layout;
    }

    public function startSection($name)
    {
        $this->currentSection = $name;
        ob_start();
    }

    public function endSection()
    {
        if ($this->currentSection) {
            $this->sections[$this->currentSection] = ob_get_clean();
            $this->currentSection = null;
        }
    }

    public function yieldSection($name)
    {
        return $this->sections[$name] ?? '';
    }

    public function render($view, $data = [])
    {
        extract($data);

        ob_start();
        include __DIR__ . '/../views/' . str_replace('.', '/', $view) . '.php';
        $content = ob_get_clean();

        if ($this->layout) {
            ob_start();
            include __DIR__ . '/../views/layouts/' . $this->layout . '.php';
            $layoutContent = ob_get_clean();
            return str_replace('@yield(\'content\')', $content, $layoutContent);
        }

        return $content;
    }
}   