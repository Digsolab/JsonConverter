<?php


namespace DSL\Converter\Tests;


use DSL\Converter\JsonConverter;
use Psr\Log\LoggerInterface;

class JsonConverterTest extends \PHPUnit_Framework_TestCase
{
    /** @var  JsonConverter */
    protected $converter;

    public function setUp()
    {
        /** @var LoggerInterface $logger */
        $logger = $this->getMock(LoggerInterface::class);
        $this->converter = new JsonConverter($logger);
    }

    public function testArrayEncode()
    {
        $data = [1, '2', 3.14, true, null, 'k' => 'foo'];
        $encodedData = $this->converter->encode($data);
        $decodedData = $this->converter->decode($encodedData, true);
        static::assertEquals($data, $decodedData);
    }

    public function testObjectEncode()
    {
        $data = new \stdClass();
        $data->foo = 'bar';
        $data->pi = 3.14;
        $data->one = 1;
        $data->bool = true;
        $data->anull = null;

        $encodedData = $this->converter->encode($data);
        $decodedData = $this->converter->decode($encodedData);
        static::assertEquals($data, $decodedData);
    }

    public function testObjectEncodeArrayDecode()
    {
        $expectedArray = ['foo' => 'bar', 'pi' => 3.14, 'one' => 1, 'bool' => true, 'anull' => null];

        $data = new \stdClass();
        $data->foo = 'bar';
        $data->pi = 3.14;
        $data->one = 1;
        $data->bool = true;
        $data->anull = null;

        $encodedData = $this->converter->encode($data);
        $decodedData = $this->converter->decode($encodedData, true);
        static::assertEquals($expectedArray, $decodedData);
    }

    public function testArrayEncodeObjectDecode()
    {
        $data = ['foo' => 'bar', 'pi' => 3.14, 'one' => 1, 'bool' => true, 'anull' => null];

        $expectedObject = new \stdClass();
        $expectedObject->foo = 'bar';
        $expectedObject->pi = 3.14;
        $expectedObject->one = 1;
        $expectedObject->bool = true;
        $expectedObject->anull = null;

        $encodedData = $this->converter->encode($data);
        $decodedData = $this->converter->decode($encodedData);
        static::assertEquals($expectedObject, $decodedData);
    }

}
