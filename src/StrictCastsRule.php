<?php declare(strict_types=1);

namespace StrictCastsPhpstan;

use PhpParser\Node;
use PhpParser\Node\Expr\Cast;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use RuntimeException;

final class StrictCastsRule implements Rule
{
    private const MATRIX = [
        ConstantStringType::class  . '->' . Cast\Bool_::class  => 'stringToBool',
        ConstantIntegerType::class . '->' . Cast\Bool_::class  => 'intToBool',
        ConstantStringType::class  . '->' . Cast\Int_::class   => 'stringToInt',
        ConstantStringType::class  . '->' . Cast\Double::class => 'stringToFloat',
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

        $matrixKey = sprintf('%s->%s', get_class($scope->getType($node->expr)), get_class($node));

        if (! isset(self::MATRIX[$matrixKey])) {
            return [];
        }

        return [sprintf("Cannot use loose cast, use StrictCasts\\%s() instead", self::MATRIX[$matrixKey])];
    }
}
