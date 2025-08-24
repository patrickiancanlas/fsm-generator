<?php

namespace App;

use Exception;

class State
{
    public array $transitionStates = [];

    public function __construct(
        public readonly string $name,
        public readonly string $output,
        public readonly bool $isFinal = true
    )
    {
    }

    public function addTransition(string $input, string $resultState)
    {
        $this->transitionStates[$input] = $resultState;
    }

    public function removeTransition(string $input)
    {
        unset($this->transitionStates[$input]);
    }

    public function getResultState($input)
    {
        if (array_key_exists($input, $this->transitionStates)) {
            return $this->transitionStates[$input];
        }

        throw new Exception('Transition not set for this state input');
    }
}