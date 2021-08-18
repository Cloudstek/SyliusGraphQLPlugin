<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusGraphqlPlugin\DataTransformer;

use Exception;
use Sylius\Bundle\ApiBundle\Command\OrderTokenValueAwareInterface;
use Sylius\Bundle\ApiBundle\DataTransformer\CommandDataTransformerInterface;
use Sylius\Component\Core\Model\OrderInterface;

/** @experimental */
final class OrderTokenValueAwareInputCommandDataTransformer implements CommandDataTransformerInterface
{
    public function transform($object, string $to, array $context = [])
    {
        /** @var OrderInterface $cart */

        if (key_exists('object_to_populate', $context)) {
            $cart = $context['object_to_populate'];
            $tokenValue = $cart->getTokenValue();
        } else if (property_exists($object, 'orderTokenValue')) {
            $tokenValue = $object->orderTokenValue;
        } else {
            throw new Exception('Token value could not be found');
        }

        $object->setOrderTokenValue($tokenValue);

        return $object;
    }

    public function supportsTransformation($object): bool
    {
        return $object instanceof OrderTokenValueAwareInterface;
    }
}
