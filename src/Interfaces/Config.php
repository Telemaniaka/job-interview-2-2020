<?php

namespace Recruitment\MailTask\Interfaces;

interface Config
{
    public function getSingleValue(string $keyName): string;

    public function getArray(string $keyName): array;
}
