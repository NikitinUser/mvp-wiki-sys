<?php

namespace App\Http\Transformers;

class BaseTransformer
{
    /**
     * @param array $data
     * @param string $classDto
     */
    public function arrayToDto(array $data, string $classDto)
    {
        $dto = new $classDto();

        foreach ($data as $key => $value) {
            if (property_exists($dto, $key)) {
                $dto->$key = $value;
            }
        }

        return $dto;
    }
}
