<?php namespace Neomerx\Tests\JsonApi\Exceptions;

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

use \Neomerx\JsonApi\Document\Error;
use \Neomerx\Tests\JsonApi\BaseTestCase;
use \Neomerx\JsonApi\Exceptions\ErrorCollection;
use \Neomerx\JsonApi\Exceptions\JsonApiException;

/**
 * @package Neomerx\Tests\JsonApi
 */
class JsonApiExceptionTest extends BaseTestCase
{
    /**
     * @var ErrorCollection
     */
    private $collection;

    /**
     * @var Error
     */
    private $error;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->collection = new ErrorCollection();
        $this->error      = new Error('some-id', null, 404, 'some-code', 'some title', 'some details');
    }

    /**
     * @inheritdoc
     */
    public function testCreateExceptionFromError()
    {
        $exception = new JsonApiException($this->error, 432);
        $this->assertEquals(432, $exception->getHttpCode());
        $this->assertCount(1, $exception->getErrors());
        $this->assertEquals([$this->error], $exception->getErrors()->getArrayCopy());
    }

    /**
     * @inheritdoc
     */
    public function testCreateExceptionFromErrorArray()
    {
        $exception = new JsonApiException([$this->error]);
        $this->assertEquals(JsonApiException::DEFAULT_HTTP_CODE, $exception->getHttpCode());
        $this->assertCount(1, $exception->getErrors());
        $this->assertEquals([$this->error], $exception->getErrors()->getArrayCopy());
    }

    /**
     * @inheritdoc
     */
    public function testCreateExceptionFromErrorCollection()
    {
        $this->collection->add($this->error);
        $exception = new JsonApiException($this->collection);
        $this->assertEquals(JsonApiException::DEFAULT_HTTP_CODE, $exception->getHttpCode());
        $this->assertCount(1, $exception->getErrors());
        $this->assertEquals([$this->error], $exception->getErrors()->getArrayCopy());
    }
}
