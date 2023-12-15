<?php
declare(strict_types=1);

namespace App\Rules;

use App\Services\Wallet\WalletServiceInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidTransactionAmount implements ValidationRule
{
    /**
     * @param int|null $fromWalletId
     * @param int|null $toWalletId
     * @param WalletServiceInterface $walletService
     * @param int|float $amount
     */
    public function __construct(
        private readonly ?int                   $fromWalletId,
        private readonly ?int                   $toWalletId,
        private readonly WalletServiceInterface $walletService,
        private readonly int|float              $amount,
    )
    {
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->fromWalletId || !$this->toWalletId
            || !$this->walletService->hasAbilityForTransactionById($this->fromWalletId, $this->toWalletId, $this->amount)
        ) {
            $fail('The balance can\'t be less then transaction amount.');
        }
    }
}
