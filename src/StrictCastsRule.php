<?php declare(strict_types=1);

namespace StrictCastsPhpstan;

use PhpParser\Node;
use PhpParser\Node\Expr\Cast;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use RuntimeException;

final class StrictCastsRule implements Rule
{
    public function getNodeType(): string
    {
        return Cast::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node instanceof Cast) {
            throw new RuntimeException();
        }

        $preferredFunction = $this->getPreferredFunction($node);

        if ($preferredFunction === null) {
            return [];
        }

        return ["Cannot use loose cast, use StrictCasts\\{$preferredFunction}() instead"];
    }

    private function getPreferredFunction(Cast $node): ?string
    {
        if ($node instanceof Cast\Bool_) {
            return 'toBool';
        }

        if ($node instanceof Cast\Double) {
            return 'toFloat';
        }

        if ($node instanceof Cast\Int_) {
            return 'toInt';
        }

        return null;
    }
}
