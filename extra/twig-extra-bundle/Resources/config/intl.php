<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Intl\Collator;
use Twig\Extra\Intl\IntlExtension;

return static function (ContainerConfigurator $container) {
    if (class_exists(Collator::class)) {
        $container->services()
            ->set(Collator::class)
                ->args([service('translator')->ignoreOnInvalid()])
        ;
    }

    $container->services()
        ->set('twig.extension.intl', IntlExtension::class)
            ->args([
                null,
                null,
                class_exists(Collator::class) ? service(Collator::class)->ignoreOnInvalid() : null,
            ])
            ->tag('twig.extension')
    ;
};
