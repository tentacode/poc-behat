<?php

declare(strict_types=1);

namespace Tests\Behat\Api;

use Coduo\PHPMatcher\PHPUnit\PHPMatcherConstraint;
use PHPUnit\Framework\Assert;

final class ApiAssert
{
    public static function assertMatchJsonPattern(
        string $json,
        string $pattern
    ): void {
        Assert::assertThat(
            $json,
            new PHPMatcherConstraint(
                $pattern,
            )
        );
    }
}
