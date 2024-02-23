<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Administrator()
 * @method static static ProductManager()
 * @method static static Support()
 * @method static static Client()
 */
final class UserRoleEnum extends Enum
{
    const Administrator = 'administrator';

    const ProductManager = 'product-manager';

    const Support = 'support';

    const Client = 'client';
}
