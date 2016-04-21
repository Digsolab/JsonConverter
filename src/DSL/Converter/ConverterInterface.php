<?php

namespace DSL\Converter;


interface ConverterInterface
{
    /**
     * @param string  $data
     * @param boolean $assoc
     * @param string  $errorMessage
     * @param boolean $throwException
     * @param integer $depth
     * @param integer $options
     *
     * @return mixed
     */
    public function decode($data, $assoc, $errorMessage, $throwException, $depth, $options);
    
    /**
     * @param mixed   $data
     * @param int     $options
     * @param string  $errorMessage
     * @param boolean $throwException
     * @param int     $depth
     *
     * @return string
     */
    public function encode($data, $options, $errorMessage, $throwException, $depth);
}