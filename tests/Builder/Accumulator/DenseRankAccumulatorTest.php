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
 * Test $denseRank accumulator
 */
class DenseRankAccumulatorTest extends PipelineTestCase
{
    public function testDenseRankPartitionsByADateField(): void
    {
        $pipeline = new Pipeline(
            Stage::setWindowFields(
                partitionBy: Expression::stringFieldPath('state'),
                sortBy: StaticFunctions::object(
                    orderDate: Sort::Asc,
                ),
                output: StaticFunctions::object(
                    denseRankOrderDateForState: Accumulator::outputWindow(
                        Accumulator::denseRank(),
                    ),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::DenseRankDenseRankPartitionsByADateField, $pipeline);
    }

    public function testDenseRankPartitionsByAnIntegerField(): void
    {
        $pipeline = new Pipeline(
            Stage::setWindowFields(
                partitionBy: Expression::stringFieldPath('state'),
                sortBy: StaticFunctions::object(
                    quantity: Sort::Desc,
                ),
                output: StaticFunctions::object(
                // The outputWindow is optional when no window property is set.
                    denseRankQuantityForState: Accumulator::denseRank(),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::DenseRankDenseRankPartitionsByAnIntegerField, $pipeline);
    }
}
