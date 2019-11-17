<?php


namespace yasmf;


class View
{
    private $relativePath;

    public function __construct($relativePath)
    {
        $this->relativePath = $relativePath;
    }

    public function render($model)
    {
        $model ;
        require_once "$this->relativePath";
    }

}