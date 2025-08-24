<?php

namespace App;

class State
{
    public array $transitions = [];

    public function __construct(
        public readonly string $name,
        public readonly string $output,
        public readonly bool $isFinal = false
    )
    {
    }

    public function addTransition(string $input, string $newState)
    {
        $this->transitions[$input] = $newState;
    }

    public function removeTransition(string $input)
    {
        unset($this->transitions[$input]);
    }
}