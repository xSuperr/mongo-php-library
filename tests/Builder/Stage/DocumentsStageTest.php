<?php

declare(strict_types=1);

namespace MongoDB\Tests\Builder\Stage;

use MongoDB\BSON\Document;
use MongoDB\Builder\Expression;
use MongoDB\Builder\Pipeline;
use MongoDB\Builder\Stage;
use MongoDB\Tests\Builder\PipelineTestCase;
use  MongoDB\StaticFunctions;

/**
 * Test $documents stage
 */
class DocumentsStageTest extends PipelineTestCase
{
    public function testTestAPipelineStage(): void
    {
        $pipeline = new Pipeline(
            Stage::documents([
                StaticFunctions::object(x: 10),
                StaticFunctions::object(x: 2),
                StaticFunctions::object(x: 5),
            ]),
            Stage::bucketAuto(
                groupBy: Expression::intFieldPath('x'),
                buckets: 4,
            ),
        );

        $this->assertSamePipeline(Pipelines::DocumentsTestAPipelineStage, $pipeline);
    }

    public function testUseADocumentsStageInALookupStage(): void
    {
        $pipeline = new Pipeline(
            Stage::match(),
            Stage::lookup(
                localField: 'zip',
                foreignField: 'zip_id',
                as: 'city_state',
                pipeline: new Pipeline(
                    Stage::documents([
                        Document::fromPHP(StaticFunctions::object(zip_id: 94301, name: 'Palo Alto, CA')),
                        Document::fromPHP(StaticFunctions::object(zip_id: 10019, name: 'New York, NY')),
                    ]),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::DocumentsUseADocumentsStageInALookupStage, $pipeline);
    }
}
