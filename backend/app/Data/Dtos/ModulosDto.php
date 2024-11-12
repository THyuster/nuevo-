<?php

class ModulosDto
{
    protected string $modulo;

    public function __construct($modulo)
    {
        $this->modulo = $modulo;
    }

    public function getModulo()
    {
        return $this->modulo;
    }

    public function setModulo($modulo)
    {
        $this->modulo = $modulo;
    }
}
