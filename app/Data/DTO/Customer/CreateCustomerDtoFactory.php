<?php

namespace App\Data\DTO\Customer;

class CreateCustomerDtoFactory
{
    public static function fromArray(array $userData): CustomerDto
    {
        $dto = new CustomerDto();

        $dto->id = $userData["id"];
        $dto->phone = $userData["phone"] ?? null;
        $dto->email = $userData["email"] ?? null;
        $dto->name = $userData["name"] ?? null;
        $dto->lastname = $userData["lastname"] ?? null;
        $dto->middlename = $userData["middlename"] ?? null;
        $dto->county = $userData["county"] ?? null;
        $dto->status = $userData["status"] ?? null;

        return $dto;
    }
}
