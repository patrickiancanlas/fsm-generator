<?php

namespace App;
use App\State;
use Exception;

class FSM
{
    private array $states;
    private string $initialStateName;
    private string $currentStateName;

    public function __construct(
        public readonly array $inputs
    )
    {

    }

    public function addState(
        string $name,
        string $output,
        bool $isInitial = false,
        bool $isFinal = false
    )
    {
        $this->states[$name] = new State(name: $name, output: $output, isFinal: $isFinal);
        if ($isInitial) {
            $this->currentStateName = $this->initialStateName = $name;
        }
    }


    public function removeState(string $name): void
    {
        if (array_key_exists($name, $this->states)) {
            unset($this->states[$name]);
        }

        if ($this->initialStateName == $name) {
            unset($this->initialStateName);
        }
    }

    public function addStateTransition(string $stateName, string $input, string $newState)
    {
        if ($this->doesStateExists(name: $stateName)) {
            throw new Exception('This state does not exist');
        }

        if ($this->doesInputExists(input: $input)) {
            throw new Exception('Wrong input');
        }

        if ($this->doesStateExists(name: $newState)) {
            throw new Exception('New state does not exist');
        }

        $this->states[$stateName]->addTransition(input: $input, newState: $newState);
    }

    public function removeStateTransition(string $stateName, string $input) {
        if ($this->doesStateExists(name: $stateName)) {
            throw new Exception('This state does not exist');
        }

        if ($this->doesInputExists(input: $input)) {
            throw new Exception('Wrong input');
        }

        $this->states[$stateName]->removeTransition(input: $input);
    }

    private function doesStateExists(string $name)
    {
        return !array_key_exists($name, $this->states);
    }

    private function doesInputExists(string $input)
    {
        return in_array($input, $this->inputs);
    }
}