<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

Assert::contains(' href="/application/latte/macro"', runRoute('/application/latte/macro'));
