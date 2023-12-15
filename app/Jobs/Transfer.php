<?php

namespace App\Jobs;

use App\Models\Wallet;
use App\Services\Convert\ConvertService;
use App\Services\Transaction\TransactionServiceInterface;
use App\Services\Wallet\WalletService;
use App\Services\Wallet\WalletServiceInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Transfer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly int $transactionId)
    {
    }

    /**
     * Execute the job.
     * @throws Exception
     */
    public function handle(TransactionServiceInterface $transactionService, WalletServiceInterface $walletService): void
    {
        $transaction = $transactionService->getById($this->transactionId);
        $storageWallet = $walletService->getStorageWallet();
        $senderWallet = $walletService->getById($transaction->from_wallet_id);
        $receiverWallet = $walletService->getById($transaction->to_wallet_id);
        DB::beginTransaction();
        try {
            $amount = ConvertService::convert($transaction->amount, $senderWallet->currency, $receiverWallet->currency);
            $commission = ConvertService::convert($transaction->amount * $transaction->commission, $senderWallet->currency, $storageWallet->currency);
            $fullSum = $transaction->amount + $transaction->amount * $transaction->commission;
            DB::table('wallets')->where(['id' => $senderWallet->id])
                ->update([
                    'balance' => $senderWallet->balance - $fullSum,
                ]);
            DB::table('wallets')->where(['id' => $storageWallet->id])
                ->update([
                'balance' => $storageWallet->balance + $commission,
            ]);
            DB::table('wallets')->where(['id' => $receiverWallet->id])
                ->update([
                'balance' => $receiverWallet->balance + $amount,
            ]);
            DB::table('transactions')->where(['id' => $transaction->id,])
                ->update([
                'finished_at' => Carbon::now(),
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $this->fail($e);
        }
    }
}
