<?php declare(strict_types=1);

namespace StrictCastsPhpstanTest;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use StrictCastsPhpstan\StrictCastsRule;

final class StrictCastsRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new StrictCastsRule();
    }

    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/file.php'], [
            [
                'Cannot use loose cast, use StrictCasts\\toBool() instead',
                3,
            ],
            [
                'Cannot use loose cast, use StrictCasts\\toBool() instead',
                4,
            ],
            [
                'Cannot use loose cast, use StrictCasts\\toInt() instead',
                5,
            ],
            [
                'Cannot use loose cast, use StrictCasts\\toFloat() instead',
                6,
            ],
            [
                'Cannot use loose cast, use StrictCasts\\toBool() instead',
                7,
            ],
            [
                'Cannot use loose cast, use StrictCasts\\toBool() instead',
                8,
            ],
        ]);
    }
}
