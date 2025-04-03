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
 * Test $linearFill accumulator
 */
class LinearFillAccumulatorTest extends PipelineTestCase
{
    public function testFillMissingValuesWithLinearInterpolation(): void
    {
        $pipeline = new Pipeline(
            Stage::setWindowFields(
                sortBy: StaticFunctions::object(
                    time: Sort::Asc,
                ),
                output: StaticFunctions::object(
                    price: Accumulator::linearFill(
                        Expression::numberFieldPath('price'),
                    ),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::LinearFillFillMissingValuesWithLinearInterpolation, $pipeline);
    }

    public function testUseMultipleFillMethodsInASingleStage(): void
    {
        $pipeline = new Pipeline(
            Stage::setWindowFields(
                sortBy: StaticFunctions::object(
                    time: Sort::Asc,
                ),
                output: StaticFunctions::object(
                    linearFillPrice: Accumulator::linearFill(
                        Expression::numberFieldPath('price'),
                    ),
                    locfPrice: Accumulator::locf(
                        Expression::numberFieldPath('price'),
                    ),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::LinearFillUseMultipleFillMethodsInASingleStage, $pipeline);
    }
}
