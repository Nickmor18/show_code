<?php

namespace App\Data\DTO\Customer;

final class CustomerDto
{
        public int $id;
        public ?string $phone;
        public ?string $email;
        public ?string $name;
        public ?string $lastname;
        public ?string $middlename;
        public ?string $county = 'RU';
        public ?bool $status;
}
