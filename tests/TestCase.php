<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    const TEST_EMAIL = 'test@mail.com';
    const TEST_PASSWORD = 'password';
}
