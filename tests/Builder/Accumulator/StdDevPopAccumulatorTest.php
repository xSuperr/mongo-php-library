<?php

declare(strict_types=1);

namespace MongoDB\Tests\Builder\Accumulator;

use MongoDB\Builder\Accumulator;
use MongoDB\Builder\Expression;
use MongoDB\Builder\Pipeline;
use MongoDB\Builder\Stage;
use MongoDB\Builder\Type\Sort;
use MongoDB\Tests\Builder\PipelineTestCase;
use  MongoDB\StaticFunctions;

/**
 * Test $stdDevPop accumulator
 */
class StdDevPopAccumulatorTest extends PipelineTestCase
{
    public function testUseInGroupStage(): void
    {
        $pipeline = new Pipeline(
            Stage::group(
                _id: Expression::fieldPath('quiz'),
                stdDev: Accumulator::stdDevPop(
                    Expression::numberFieldPath('score'),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::StdDevPopUseInGroupStage, $pipeline);
    }

    public function testUseInSetWindowFieldsStage(): void
    {
        $pipeline = new Pipeline(
            Stage::setWindowFields(
                partitionBy: Expression::fieldPath('state'),
                sortBy: StaticFunctions::object(
                    orderDate: Sort::Asc,
                ),
                output: StaticFunctions::object(
                    stdDevPopQuantityForState: Accumulator::outputWindow(
                        Accumulator::stdDevPop(
                            Expression::numberFieldPath('quantity'),
                        ),
                        documents: ['unbounded', 'current'],
                    ),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::StdDevPopUseInSetWindowFieldsStage, $pipeline);
    }
}
