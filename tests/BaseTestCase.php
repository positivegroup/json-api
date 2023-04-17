<?php

namespace Neomerx\Tests\JsonApi;

/**
 * Copyright 2015-2017 info@neomerx.com
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use Mockery;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Neomerx\JsonApi\Contracts\Encoder\EncoderInterface;
use Neomerx\JsonApi\Encoder\EncoderOptions;
use Neomerx\JsonApi\Factories\Factory;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    /**
     * Tear down test.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * @return EncoderInterface
     */
    protected function createLoggedEncoder(array $schemas, EncoderOptions $encodeOptions = null)
    {
        $factory = new Factory();

        $path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'neomerx-json-api-tests.log';
        $log = new Logger('json-api');
        $log->pushHandler(new StreamHandler($path));
        $factory->setLogger($log);

        $container = $factory->createContainer($schemas);
        $encoder = $factory->createEncoder($container, $encodeOptions);

        return $encoder;
    }
}
