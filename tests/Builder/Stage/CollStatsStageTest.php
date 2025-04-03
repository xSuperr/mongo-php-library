<?php

declare(strict_types=1);

namespace MongoDB\Tests\Builder\Stage;

use MongoDB\Builder\Pipeline;
use MongoDB\Builder\Stage;
use MongoDB\Tests\Builder\PipelineTestCase;
use StaticFunctions;

/**
 * Test $collStats stage
 */
class CollStatsStageTest extends PipelineTestCase
{
    public function testCountField(): void
    {
        $pipeline = new Pipeline(
            Stage::collStats(
                count: StaticFunctions::object(),
            ),
        );

        $this->assertSamePipeline(Pipelines::CollStatsCountField, $pipeline);
    }

    public function testLatencyStatsDocument(): void
    {
        $pipeline = new Pipeline(
            Stage::collStats(
                latencyStats: StaticFunctions::object(
                    histograms: true,
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::CollStatsLatencyStatsDocument, $pipeline);
    }

    public function testQueryExecStatsDocument(): void
    {
        $pipeline = new Pipeline(
            Stage::collStats(
                queryExecStats: StaticFunctions::object(),
            ),
        );

        $this->assertSamePipeline(Pipelines::CollStatsQueryExecStatsDocument, $pipeline);
    }

    public function testStorageStatsDocument(): void
    {
        $pipeline = new Pipeline(
            Stage::collStats(
                storageStats: StaticFunctions::object(),
            ),
        );

        $this->assertSamePipeline(Pipelines::CollStatsStorageStatsDocument, $pipeline);
    }
}
