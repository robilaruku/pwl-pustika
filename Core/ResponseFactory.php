<?php

namespace Core;

/**
 * Class is responsible for creating responses easily
 */
class ResponseFactory {

    /**
     * Render view with sections and layout
     *
     * @param \Core\Config $config
     * @param string|array $templates
     * @param array $data
     * @return Response
     */
    public static function view($config = \Core\Config::class ?? null, $templates, $data = []): Response
    {
        // Start capturing the output
        ob_start();
        extract($data);

        if (is_array($templates)) {
            foreach ($templates as $template) {
                include $config::VIEW_PATH . str_replace('.', DIRECTORY_SEPARATOR, $template) . '.php';
            }
        } else {
            include $config::VIEW_PATH . str_replace('.', DIRECTORY_SEPARATOR, $templates) . '.php';
        }

        // Get the content and clean the buffer
        $content = ob_get_clean();

        // If layout is specified, render the layout with the content
        if (isset($data['layout'])) {
            $layoutPath = $config::VIEW_PATH . 'layouts/' . $data['layout'] . '.php';
            if (file_exists($layoutPath)) {
                ob_start();
                include $layoutPath;
                $responseContent = ob_get_clean();
            } else {
                $responseContent = $content;
            }
        } else {
            $responseContent = $content;
        }

        // Create and return the response
        return new Response($responseContent, [
            'Content-Type' => 'text/html'
        ], 200);
    }

    /**
     * Generate json response 
     *
     * @param array $data
     * @param integer $options
     * @param integer $depth
     * @return Response
     */
    public static function json($data, $options = 0, $depth = 512): Response
    {
        $response = new Response(json_encode($data, $options, $depth), [
            'Content-Type' => 'application/json'
        ], 200);
        return $response;
    }
}