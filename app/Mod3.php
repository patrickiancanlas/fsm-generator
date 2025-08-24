<?php

namespace App;

use App\FSM;

class Mod3
{
    public FSM $fsm;

    public function __construct()
    {
        $inputs = ['0', '1'];

        $this->fsm = new FSM($inputs);

        // Add states
        $this->fsm->addState(name: 'S0', output: '0', isFinal: true, isInitial: true);
        $this->fsm->addState(name: 'S1', output: '1', isFinal: true);
        $this->fsm->addState(name: 'S2', output: '2', isFinal: true);

        // Add state transition for S0
        $this->fsm->addStateTransition(stateName: 'S0', input: '0', resultState: 'S0');
        $this->fsm->addStateTransition(stateName: 'S0', input: '1', resultState: 'S1');

        // Add state transition for S1
        $this->fsm->addStateTransition(stateName: 'S1', input: '0', resultState: 'S2');
        $this->fsm->addStateTransition(stateName: 'S1', input: '1', resultState: 'S0');

        // Add state transition for S2
        $this->fsm->addStateTransition(stateName: 'S2', input: '0', resultState: 'S1');
        $this->fsm->addStateTransition(stateName: 'S2', input: '1', resultState: 'S2');
    }

    public function run(string $binaryInteger)
    {
        $inputArray = str_split($binaryInteger);
        foreach ($inputArray AS $input) {
            $this->fsm->runTransition(input: $input);
        }

        return $this->fsm->returnFinalState()['state_output'];
    }
}