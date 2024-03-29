<?php

namespace Pjson;

class Renderer
{
    /**
     * Path to templates directory
     *
     * @var string
     */
    protected $templatesPath;

    /**
     * Constructor
     *
     * @param string $templatesPath
     */
    public function __construct($templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }

    /**
     * Renders template returning json
     *
     * @param string $template
     * @param array $data
     * @return string
     */
    public function render($template, array $data)
    {
        $pjson = $this->protectedScopeInclude($template, new Pjson, $data);

        $serializedData = $pjson->serialize();
        if ($serializedData === false) {
            throw new \RuntimeException("Pjson serialization failed.");
        }

        return $serializedData;
    }

    /**
     * Isolates scope for mapping pjson object
     * during template render
     *
     * @param string $template
     * @param Pjson $pjson
     * @param array $data
     * @return Pjson
     */
    protected function protectedScopeInclude($template, Pjson $pjson, array $data)
    {
        extract($data);

        include($this->templatesPath . $template);

        return $pjson;
    }
}

