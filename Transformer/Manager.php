<?php


namespace App\Pkg;


class Manager
{
    private $content;
    private TransformerAbstract $transformer;

    function __construct($content, $transformer)
    {
        $this->content = $content;
        $this->transformer = $transformer;
    }

    function data()
    {
        return $this->transformer->do($this->content);
    }
}
