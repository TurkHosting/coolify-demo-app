<?php

test('registration is disabled', function () {
    // Registration feature is disabled in config/fortify.php
    // Verify that registration routes don't exist
    expect(config('fortify.features'))->not->toContain(\Laravel\Fortify\Features::registration());
});
