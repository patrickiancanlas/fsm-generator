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

    public function addStateTransition(string $stateName, string $input, string $resultState)
    {
        if ($this->doesStateExists(name: $stateName)) {
            throw new Exception('This state does not exist');
        }

        if ($this->doesInputExists(input: $input)) {
            throw new Exception('Input not recognized in this FSM');
        }

        if ($this->doesStateExists(name: $resultState)) {
            throw new Exception('Result state does not exist');
        }

        $this->states[$stateName]->addTransition(input: $input, newState: $resultState);
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

    public function runTransition(string $input)
    {
        if ($this->doesInputExists($input)) {
            throw new Exception('Input not recognized in this FSM');
        }

        $currentState = $this->states[$this->currentStateName];

        // Set new state for FSM
        $this->currentStateName = $currentState->getResultState(input: $input);
    }

    public function returnCurrentState()
    {
        $currentState = $this->states[$this->currentStateName];
        if (!$currentState->isFinal) {
            throw new Exception('This state is not final');
        }

        return [
            'state_name' => $currentState->name,
            'state_output' => $currentState->output
        ];
    }
}