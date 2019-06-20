<?php declare(strict_types=1);

namespace StrictCastsPhpstan;

use PhpParser\Node;
use PhpParser\Node\Expr\Cast;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\StringType;
use RuntimeException;

final class StrictCastsRule implements Rule
{
    private const MATRIX = [
        'string->' . Cast\Bool_::class  => 'stringToBool',
        'int->'    . Cast\Bool_::class  => 'intToBool',
        'string->' . Cast\Int_::class   => 'stringToInt',
        'string->' . Cast\Double::class => 'stringToFloat',
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

        $fromType = $scope->getType($node->expr);

        if ($fromType instanceof StringType) {
            $from = 'string';
        } elseif ($fromType instanceof IntegerType) {
            $from = 'int';
        } else {
            return [];
        }

        $matrixKey = sprintf('%s->%s', $from, get_class($node));

        if (! isset(self::MATRIX[$matrixKey])) {
            return [];
        }

        return [sprintf("Cannot use loose cast, use StrictCasts\\%s() instead", self::MATRIX[$matrixKey])];
    }
}
