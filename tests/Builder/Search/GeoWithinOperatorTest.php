<?php

declare(strict_types=1);

namespace MongoDB\Tests\Builder\Search;

use MongoDB\Builder\Pipeline;
use MongoDB\Builder\Search;
use MongoDB\Builder\Stage;
use MongoDB\Tests\Builder\PipelineTestCase;
use StaticFunctions;

/**
 * Test geoWithin search
 */
class GeoWithinOperatorTest extends PipelineTestCase
{
    public function testBox(): void
    {
        $pipeline = new Pipeline(
            Stage::search(
                Search::geoWithin(
                    path: 'address.location',
                    box: StaticFunctions::object(
                        bottomLeft: StaticFunctions::object(
                            type: 'Point',
                            coordinates: [
                                112.467,
                                -55.05,
                            ],
                        ),
                        topRight: StaticFunctions::object(
                            type: 'Point',
                            coordinates: [
                                168,
                                -9.133,
                            ],
                        ),
                    ),
                ),
            ),
            Stage::limit(3),
            Stage::project(
                _id: 0,
                name: 1,
                address: 1,
            ),
        );

        $this->assertSamePipeline(Pipelines::GeoWithinBox, $pipeline);
    }

    public function testCircle(): void
    {
        $pipeline = new Pipeline(
            Stage::search(
                Search::geoWithin(
                    path: 'address.location',
                    circle: StaticFunctions::object(
                        center: StaticFunctions::object(
                            type: 'Point',
                            coordinates: [
                                -73.54,
                                45.54,
                            ],
                        ),
                        radius: 1600,
                    ),
                ),
            ),
            Stage::limit(3),
            Stage::project(
                _id: 0,
                name: 1,
                address: 1,
            ),
        );

        $this->assertSamePipeline(Pipelines::GeoWithinCircle, $pipeline);
    }

    public function testGeometry(): void
    {
        $pipeline = new Pipeline(
            Stage::search(
                Search::geoWithin(
                    path: 'address.location',
                    geometry: StaticFunctions::object(
                        type: 'Polygon',
                        coordinates: [
                            [
                                [
                                    -161.323242,
                                    22.512557,
                                ],
                                [
                                    -152.446289,
                                    22.065278,
                                ],
                                [
                                    -156.09375,
                                    17.811456,
                                ],
                                [
                                    -161.323242,
                                    22.512557,
                                ],
                            ],
                        ],
                    ),
                ),
            ),
            Stage::limit(3),
            Stage::project(
                _id: 0,
                name: 1,
                address: 1,
            ),
        );

        $this->assertSamePipeline(Pipelines::GeoWithinGeometry, $pipeline);
    }
}
