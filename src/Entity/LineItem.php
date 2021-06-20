<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\RefundPlugin\Entity;

use Sylius\RefundPlugin\Exception\LineItemsCannotBeMerged;

class LineItem implements LineItemInterface
{
    /** @var int|null */
    protected $id;

    /** @var string */
    protected $name;

    /** @var int */
    protected $quantity;

    /** @var int */
    protected $unitNetPrice;

    /** @var int */
    protected $unitGrossPrice;

    /** @var int */
    protected $netValue;

    /** @var int */
    protected $grossValue;

    /** @var int */
    protected $taxAmount;

    /** @var string|null */
    protected $reference;

    /** @var string|null */
    protected $taxRate;

    public function __construct(
        string $name,
        int $quantity,
        int $unitNetPrice,
        int $unitGrossPrice,
        int $netValue,
        int $grossValue,
        int $taxAmount,
        ?string $taxRate = null,
        ?string $reference = null
    ) {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->unitNetPrice = $unitNetPrice;
        $this->unitGrossPrice = $unitGrossPrice;
        $this->netValue = $netValue;
        $this->grossValue = $grossValue;
        $this->taxAmount = $taxAmount;
        $this->taxRate = $taxRate;
        $this->reference = $reference;
    }

    public function getId(): ?int
    {
        return $this->id();
    }

    public function id(): ?int
    {
        return $this->id;
    }
    
    public function reference()
    {
        return $this->reference;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function unitNetPrice(): int
    {
        return $this->unitNetPrice;
    }

    public function unitGrossPrice(): int
    {
        return $this->unitGrossPrice;
    }

    public function netValue(): int
    {
        return $this->netValue;
    }

    public function grossValue(): int
    {
        return $this->grossValue;
    }

    public function taxAmount(): int
    {
        return $this->taxAmount;
    }

    public function taxRate(): ?string
    {
        return $this->taxRate;
    }

    public function merge(LineItemInterface $newLineItem): void
    {
        if (!$this->compare($newLineItem)) {
            throw LineItemsCannotBeMerged::occur();
        }

        $this->quantity += $newLineItem->quantity();
        $this->netValue += $newLineItem->netValue();
        $this->grossValue += $newLineItem->grossValue();
        $this->taxAmount += $newLineItem->taxAmount();
    }

    public function compare(LineItemInterface $lineItem): bool
    {
        return
            $this->name() === $lineItem->name() &&
            $this->unitNetPrice() === $lineItem->unitNetPrice() &&
            $this->unitGrossPrice() === $lineItem->unitGrossPrice() &&
            $this->taxRate() === $lineItem->taxRate()
        ;
    }
}
