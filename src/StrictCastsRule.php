<?php declare(strict_types=1);

namespace StrictCastsPhpstan;

use PhpParser\Node;
use PhpParser\Node\Expr\Cast;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use RuntimeException;

final class StrictCastsRule implements Rule
{
    private const MATRIX = [
        'Scalar_String->'  . Cast\Bool_::class   => 'stringToBool',
        'Scalar_LNumber->' . Cast\Bool_::class   => 'intToBool',
        'Scalar_String->'  . Cast\Int_::class    => 'stringToInt',
        'Scalar_String->'  .  Cast\Double::class => 'stringToFloat',
    ];

    public function getNodeType(): string
    {
        return Cast::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node instanceof Cast) {
            throw new RuntimeException();
        }

        $matrixKey = sprintf('%s->%s', $node->expr->getType(), get_class($node));

        if (! isset(self::MATRIX[$matrixKey])) {
            return [];
        }

        return [sprintf("Cannot use loose cast, use StrictCasts\\%s() instead", self::MATRIX[$matrixKey])];
    }
}
