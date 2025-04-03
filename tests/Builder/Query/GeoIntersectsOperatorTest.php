<?php

declare(strict_types=1);

namespace MongoDB\Tests\Builder\Query;

use MongoDB\Builder\Pipeline;
use MongoDB\Builder\Query;
use MongoDB\Builder\Stage;
use MongoDB\Tests\Builder\PipelineTestCase;
use  MongoDB\StaticFunctions;

/**
 * Test $geoIntersects query
 */
class GeoIntersectsOperatorTest extends PipelineTestCase
{
    public function testIntersectsABigPolygon(): void
    {
        $pipeline = new Pipeline(
            Stage::match(
                loc: Query::geoIntersects(
                    Query::geometry(
                        type: 'Polygon',
                        coordinates: [[[-100, 60], [-100, 0], [-100, -60], [100, -60], [100, 60], [-100, 60]]],
                        crs: StaticFunctions::object(
                            type: 'name',
                            properties: StaticFunctions::object(
                                name: 'urn:x-mongodb:crs:strictwinding:EPSG:4326',
                            ),
                        ),
                    ),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::GeoIntersectsIntersectsABigPolygon, $pipeline);
    }

    public function testIntersectsAPolygon(): void
    {
        $pipeline = new Pipeline(
            Stage::match(
                loc: Query::geoIntersects(
                    Query::geometry(
                        type: 'Polygon',
                        coordinates: [[[0, 0], [3, 6], [6, 1], [0, 0]]],
                    ),
                ),
            ),
        );

        $this->assertSamePipeline(Pipelines::GeoIntersectsIntersectsAPolygon, $pipeline);
    }
}
