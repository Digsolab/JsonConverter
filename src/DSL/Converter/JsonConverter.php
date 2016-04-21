<?php

namespace DSL\Converter;

use Psr\Log\LoggerInterface;

/**
 * Universal json decoder with built-in error logging
 * @author Lexey Felde <a.felde@digsolab.com>
 */
class JsonConverter implements ConverterInterface
{
    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * json_decode() decorator
     *
     * @param string  $data
     * @param boolean $assoc
     * @param string  $errorMessage
     * @param boolean $throwException
     * @param integer $depth
     * @param integer $options
     *
     * @return mixed
     *
     * @throws ConversionException
     */
    public function decode($data, $assoc = false, $errorMessage = '', $throwException = true, $depth = 512, $options = 0)
    {
        $data = @json_decode($data, $assoc, $depth, $options);
        $this->jsonLastError($data, $errorMessage, $throwException);

        return $data;
    }

    /**
     * json_encode() decorator
     *
     * @param mixed   $data
     * @param int     $options
     * @param string  $errorMessage
     * @param boolean $throwException
     * @param int     $depth
     *
     * @return string
     *
     * @throws ConversionException
     */
    public function encode($data, $options = 0, $errorMessage = '', $throwException = true, $depth = 512)
    {
        $jsonString = @json_encode($data, $options, $depth);
        $this->jsonLastError($data, $errorMessage, $throwException);

        return $jsonString;
    }

    /**
     * json_last_error() decoder with build-in error logging
     *
     * @param mixed  $data
     * @param string $errorMessage
     * @param bool   $throwException
     *
     * @throws ConversionException
     */
    private function jsonLastError($data, $errorMessage = '', $throwException = true)
    {
        if (json_last_error() !== JSON_ERROR_NONE) {
            $message = sprintf('%s, json last error: %s', $errorMessage, json_last_error_msg());
            $data    = var_export($data, true);

            $this->logger->error('jsonLastError var_export: ' . $data);
            if (true === $throwException) {
                throw new ConversionException($message);
            } else {
                $this->logger->error($message);
            }
        }
    }
}