<?php

namespace App\Helpers;

use Illuminate\Support\MessageBag;
use App\Exceptions\ValidationException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer as BaseObjectNormalizer;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

/**
 * Converts between objects and arrays using the PropertyAccess component.
 */
class ObjectNormalizer extends BaseObjectNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return is_object($type) || class_exists($type);
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $allowedAttributes = $this->getAllowedAttributes($class, $context, true);
        $normalizedData = $this->prepareForDenormalization($data);

        if (is_string($class)) {
            $reflectionClass = new \ReflectionClass($class);
            $errors = $this->validateConstructor($normalizedData, $class, $reflectionClass, $allowedAttributes);
            $class = $reflectionClass->newInstanceWithoutConstructor();
        } else $errors = new MessageBag();

        foreach ($normalizedData as $attribute => $value) {
            if ($this->nameConverter) {
                $attribute = $this->nameConverter->denormalize($attribute);
            }

            $allowed = $allowedAttributes === false || in_array($attribute, $allowedAttributes);
            $ignored = in_array($attribute, $this->ignoredAttributes);

            if ($allowed && !$ignored) {
                try {
                    $this->propertyAccessor->setValue($class, $attribute, $value);
                } catch (ValidationException $exception) {
                    $errors->merge($exception->errors);
                } catch (NoSuchPropertyException $exception) {
                    // Properties not found are ignored
                }
            }
        }

        if ($errors->any()) {
            throw new ValidationException($errors);
        }

        return $class;
    }

    /**
     * {@inheritdoc}
     */
    protected function validateConstructor(array &$data, $class, \ReflectionClass $reflectionClass, $allowedAttributes)
    {
        $errors = new MessageBag();

        $constructor = $reflectionClass->getConstructor();
        if (!$constructor) return $errors;

        $constructorParameters = $constructor->getParameters();

        $params = [];
        foreach ($constructorParameters as $constructorParameter) {
            $paramName = $constructorParameter->name;
            $key = $this->nameConverter ? $this->nameConverter->normalize($paramName) : $paramName;

            $allowed = $allowedAttributes === false || in_array($paramName, $allowedAttributes);
            $ignored = in_array($paramName, $this->ignoredAttributes);
            
            if ($constructorParameter->isDefaultValueAvailable()) {
                $data[$key] = $constructorParameter->getDefaultValue();
            } elseif (!$allowed || $ignored) {
                throw new \Exception("The $key field is required, but was explicitly unallowed.");
            } elseif (!array_key_exists($key, $data)) {
                $errors->add($key, "The $key field is required.");
            }
        }

        return $errors;
    }
}
