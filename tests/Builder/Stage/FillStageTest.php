<?php

declare(strict_types=1);

namespace MongoDB\Tests\Builder\Stage;

use MongoDB\Builder\Expression;
use MongoDB\Builder\Pipeline;
use MongoDB\Builder\Stage;
use MongoDB\Builder\Type\Sort;
use MongoDB\Tests\Builder\PipelineTestCase;
use StaticFunctions;

/**
 * Test $fill stage
 */
class FillStageTest extends PipelineTestCase
{
    public function testFillDataForDistinctPartitions(): void
    {
        $pipeline = new Pipeline(
            Stage::fill(
                sortBy: StaticFunctions::object(
                    date: Sort::Asc,
                ),
                partitionBy: StaticFunctions::object(
                    restaurant: Expression::stringFieldPath('restaurant'),
                ),
                output: StaticFunctions::object(
                    score: StaticFunctions::object(method: 'locf'),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::FillFillDataForDistinctPartitions, $pipeline);
    }

    public function testFillMissingFieldValuesBasedOnTheLastObservedValue(): void
    {
        $pipeline = new Pipeline(
            Stage::fill(
                sortBy: StaticFunctions::object(
                    date: Sort::Asc,
                ),
                output: StaticFunctions::object(
                    score: StaticFunctions::object(method: 'locf'),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::FillFillMissingFieldValuesBasedOnTheLastObservedValue, $pipeline);
    }

    public function testFillMissingFieldValuesWithAConstantValue(): void
    {
        $pipeline = new Pipeline(
            Stage::fill(
                output: StaticFunctions::object(
                    bootsSold: StaticFunctions::object(value: 0),
                    sandalsSold: StaticFunctions::object(value: 0),
                    sneakersSold: StaticFunctions::object(value: 0),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::FillFillMissingFieldValuesWithAConstantValue, $pipeline);
    }

    public function testFillMissingFieldValuesWithLinearInterpolation(): void
    {
        $pipeline = new Pipeline(
            Stage::fill(
                sortBy: StaticFunctions::object(
                    time: Sort::Asc,
                ),
                output: StaticFunctions::object(
                    price: StaticFunctions::object(method: 'linear'),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::FillFillMissingFieldValuesWithLinearInterpolation, $pipeline);
    }

    public function testIndicateIfAFieldWasPopulatedUsingFill(): void
    {
        $pipeline = new Pipeline(
            Stage::set(
                valueExisted: Expression::ifNull(
                    Expression::toBool(
                        Expression::toString(
                            Expression::fieldPath('score'),
                        ),
                    ),
                    false,
                ),
            ),
            Stage::fill(
                sortBy: StaticFunctions::object(
                    date: Sort::Asc,
                ),
                output: StaticFunctions::object(
                    score: StaticFunctions::object(method: 'locf'),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::FillIndicateIfAFieldWasPopulatedUsingFill, $pipeline);
    }
}
