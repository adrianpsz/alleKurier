<?php

namespace App\Core\Invoice\Domain\Status;

use App\Core\Invoice\Domain\Exception\InvoiceException;

enum InvoiceStatus: string
{
    case NEW = 'new';
    case PAID = 'paid';
    case CANCELED = 'canceled';

    public static function valueFromName(string $name): self
    {
        $name = strtoupper($name);
        try {
            $value = constant("self::$name");
        } catch (\Error $e) {
            throw new InvoiceException("Wrong invoice status: ".$name);
        }

        return $value;
    }
}
