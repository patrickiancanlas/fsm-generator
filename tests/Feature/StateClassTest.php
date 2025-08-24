<?php

use App\State;

it('tests adding a transition', function () {
    $state = new State('S0', '0');
    $state->addTransition('0', 'S1');
    expect($state->getResultState('0'))->toBe('S1');
});

it('tests removing a transition', function () {
    $state = new State('S0', '0');
    $state->addTransition('0', 'S1');
    $state->removeTransition('0');
    expect(fn() => $state->getResultState('0'))->toThrow('Transition not set for this state input');
});