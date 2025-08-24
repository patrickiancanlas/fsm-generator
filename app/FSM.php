<?php

namespace App;
use App\State;
use Exception;

class FSM
{
    private array $states;
    private string $initialStateName;
    private string $finalStateName;

    public function __construct(
        public readonly array $inputs
    )
    {

    }

    public function addState(
        string $name,
        string $output,
        bool $isFinal = true,
        bool $isInitial = false,
    )
    {
        $this->states[$name] = new State(name: $name, output: $output, isFinal: $isFinal);
        if ($isInitial) {
            $this->finalStateName = $this->initialStateName = $name;
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
        if (!$this->doesStateExists(name: $stateName)) {
            throw new Exception('This state does not exist');
        }

        if (!$this->doesInputExists(input: $input)) {
            throw new Exception('Input not recognized in this FSM');
        }

        if (!$this->doesStateExists(name: $resultState)) {
            throw new Exception('Result state does not exist');
        }

        $this->states[$stateName]->addTransition(input: $input, resultState: $resultState);
    }

    public function removeStateTransition(string $stateName, string $input) {
        if (!$this->doesStateExists(name: $stateName)) {
            throw new Exception('This state does not exist');
        }

        if (!$this->doesInputExists(input: $input)) {
            throw new Exception('Wrong input');
        }

        $this->states[$stateName]->removeTransition(input: $input);
    }

    public function doesStateExists(string $name)
    {
        return array_key_exists($name, $this->states);
    }

    public function doesInputExists(string $input)
    {
        return in_array($input, $this->inputs, true);
    }

    public function runTransition(string $input)
    {
        if (!$this->doesInputExists($input)) {
            throw new Exception('Input not recognized in this FSM');
        }

        $finalState = $this->states[$this->finalStateName];

        // Set final state for FSM
        $this->finalStateName = $finalState->getResultState(input: $input);
    }

    public function returnFinalState()
    {
        $finalState = $this->states[$this->finalStateName];
        if (!$finalState->isFinal) {
            throw new Exception('This state is not final');
        }

        return [
            'state_name' => $finalState->name,
            'state_output' => $finalState->output
        ];
    }
}