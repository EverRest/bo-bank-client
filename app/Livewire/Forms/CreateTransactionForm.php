<?php
declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\User;
use App\Models\Wallet;
use App\Rules\ValidTransactionAmount;
use App\Services\Transaction\TransactionServiceInterface;
use App\Services\User\UserServiceInterface;
use App\Services\Wallet\WalletService;
use App\Services\Wallet\WalletServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateTransactionForm extends Component
{
    /**
     * @var int|null
     */
    public int|null $senderWalletId = null;

    /**
     * @var int|null
     */
    public int|null $receiverWalletId = null;

    /**
     * @var User
     */
    public User $selectedReceiver;

    /**
     * @var int|null
     */
    public int|null $senderId = null;

    /**
     * @var int|null
     */
    public int|null $receiverId = null;

    /**
     * @var Collection
     */
    public Collection $receiverWallets;

    /**
     * @var float|int
     */
    public float|int $amount = 0.00;

    /**
     * @var Collection
     */
    public Collection $senderWallets;

    /**
     * @param $receiverId
     * @param UserServiceInterface $userService
     *
     * @return void
     */
    public function updatedReceiverId($receiverId, UserServiceInterface $userService): void
    {
        $this->receiverWallets = Collection::make();
        if ($receiverId) {
            $receiver = $userService->getById($receiverId);
            $this->receiverWallets = $receiver->wallets ?? Collection::make();
        }
    }

    /**
     * @param UserServiceInterface $userService
     * @param WalletServiceInterface $walletService
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render(UserServiceInterface $userService, WalletServiceInterface $walletService): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $users = $userService->all(Collection::make());
        $this->senderId = Auth::id();
        $this->senderWallets = $walletService->all(Collection::make(['user_id' => $this->senderId]));

        return view('livewire.forms.create-transaction-form', [
            'users' => $users,
            'receiverWallets' => $this->receiverWallets ?? [],
        ]);
    }

    /**
     * @param TransactionServiceInterface $transactionService
     * @param WalletServiceInterface $walletService
     * @return void
     */
    public function createTransaction(TransactionServiceInterface $transactionService, WalletServiceInterface $walletService): void
    {
        $this->validate([
            'senderWalletId' => [
                'required',
                'exists:wallets,id',
                new ValidTransactionAmount($this->senderWalletId, $this->receiverWalletId, $walletService, $this->amount),
            ],
            'receiverWalletId' => ['required', 'exists:wallets,id',],
            'amount' => ['required', 'numeric', 'min:10', 'max:100000'],
        ]);
        /**
         * @var Wallet $senderWallet
         */
        $senderWallet = $walletService->getById($this->senderWalletId);
        /**
         * @var Wallet $receiverWallet
         */
        $receiverWallet = $walletService->getById($this->receiverWalletId);
        $attributes = Collection::make([
            'from_wallet_id' => $this->senderWalletId,
            'to_wallet_id' => $this->receiverWalletId,
            'amount' => $this->amount,
            'commission' => WalletService::getCommission($senderWallet, $receiverWallet),
        ]);
        $transactionService->create($attributes);
        session()->flash('success', 'Transaction created successfully.');
        $walletUrl = route('wallets.show', ['wallet' => $this->senderWalletId]);
        $this->reset(['amount', 'receiverWalletId', 'senderWalletId', 'receiverId']);
        redirect()->to($walletUrl);
    }
}
