<?php

declare(strict_types=1);

namespace MongoDB\Tests\Builder\Query;

use MongoDB\Builder\Pipeline;
use MongoDB\Builder\Query;
use MongoDB\Builder\Stage;
use MongoDB\Tests\Builder\PipelineTestCase;
use StaticFunctions;

/**
 * Test $jsonSchema query
 */
class JsonSchemaOperatorTest extends PipelineTestCase
{
    public function testExample(): void
    {
        $pipeline = new Pipeline(
            Stage::match(
                Query::jsonSchema(StaticFunctions::object(
                    required: ['name', 'major', 'gpa', 'address'],
                    properties: StaticFunctions::object(
                        name: StaticFunctions::object(
                            bsonType: 'string',
                            description: 'must be a string and is required',
                        ),
                        address: StaticFunctions::object(
                            bsonType: 'object',
                            required: ['zipcode'],
                            properties: StaticFunctions::object(
                                zipcode: StaticFunctions::object(bsonType: 'string'),
                                street: StaticFunctions::object(bsonType: 'string'),
                            ),
                        ),
                    ),
                )),
            ),
        );

        $this->assertSamePipeline(Pipelines::JsonSchemaExample, $pipeline);
    }
}
