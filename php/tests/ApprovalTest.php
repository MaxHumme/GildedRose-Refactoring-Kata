<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use ApprovalTests\Approvals;

/**
 * This unit test uses [Approvals](https://github.com/approvals/ApprovalTests.php).
 */
class ApprovalTest extends TestCase
{
    public function testThirtyDays(): void
    {
        ob_start();

        $argv = ["", "30"];
        include(__DIR__ . '/../fixtures/texttest_fixture.php');

        $output = ob_get_clean();

        Approvals::verifyString($output);
    }
}
