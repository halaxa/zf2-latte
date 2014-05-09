<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

Assert::same("Latte is working.\n", runRoute('/'));
