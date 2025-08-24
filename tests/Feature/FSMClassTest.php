<?php

use App\FSM;

it('tests adding a state to the fsm', function () {
    $fsm = new FSM([0]);

    $fsm->addState('S0', '0');

    expect($fsm->doesStateExists('S0'))->toBeTrue();
});

it('tests removing a state from the fsm', function () {
    $fsm = new FSM([0]);

    $fsm->addState('S0', '0', true, true);
    $fsm->removeState('S0');

    expect($fsm->doesStateExists('S0'))->toBeFalse();
});

it('tests adding a transition with an invalid input to a specific state', function () {
    $fsm = new FSM([0, 1]);

    $fsm->addState('S0', '0');
    $fsm->addState('S1', '1');

    expect(fn () => $fsm->addStateTransition('S0', '2', 'S1'))
        ->toThrow('Input not recognized in this FSM');
});