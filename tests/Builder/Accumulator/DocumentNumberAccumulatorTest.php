<?php

declare(strict_types=1);

namespace MongoDB\Tests\Builder\Accumulator;

use MongoDB\Builder\Accumulator;
use MongoDB\Builder\Expression;
use MongoDB\Builder\Pipeline;
use MongoDB\Builder\Stage;
use MongoDB\Builder\Type\Sort;
use MongoDB\Tests\Builder\PipelineTestCase;
use StaticFunctions;

/**
 * Test $documentNumber accumulator
 */
class DocumentNumberAccumulatorTest extends PipelineTestCase
{
    public function testDocumentNumberForEachState(): void
    {
        $pipeline = new Pipeline(
            Stage::setWindowFields(
                partitionBy: Expression::stringFieldPath('state'),
                sortBy: StaticFunctions::object(
                    quantity: Sort::Desc,
                ),
                output: StaticFunctions::object(
                    documentNumberForState: Accumulator::documentNumber(),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::DocumentNumberDocumentNumberForEachState, $pipeline);
    }
}
