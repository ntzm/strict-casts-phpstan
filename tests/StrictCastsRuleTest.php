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
                'Cannot use loose cast, use StrictCasts\\stringToBool() instead',
                3,
            ],
            [
                'Cannot use loose cast, use StrictCasts\\intToBool() instead',
                4,
            ],
            [
                'Cannot use loose cast, use StrictCasts\\stringToInt() instead',
                5,
            ],
            [
                'Cannot use loose cast, use StrictCasts\\stringToFloat() instead',
                6,
            ],
            [
                'Cannot use loose cast, use StrictCasts\\stringToBool() instead',
                7,
            ],
            [
                'Cannot use loose cast, use StrictCasts\\stringToBool() instead',
                8,
            ],
        ]);
    }
}
