<?php

namespace InteractiveSolutions\HoneycombWallet\Services;

use Illuminate\Container\EntryNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;
use InteractiveSolutions\HoneycombWallet\Exceptions\WalletNotEnoughBalanceException;
use InteractiveSolutions\HoneycombWallet\Models\HCWallet;
use InteractiveSolutions\HoneycombWallet\Repositories\HCWalletHistoryRepository;
use InteractiveSolutions\HoneycombWallet\Repositories\HCWalletRepository;
use Symfony\Component\Routing\Exception\InvalidParameterException;

/**
 * Class HCWalletBalanceService
 * @package InteractiveSolutions\HoneycombWallet\Services
 */
class HCWalletBalanceService
{
    /**
     * @var HCWalletRepository
     */
    private $walletRepository;
    /**
     * @var HCWalletHistoryRepository
     */
    private $historyRepository;

    /**
     * HCWalletBalanceService constructor.
     * @param HCWalletRepository $walletRepository
     * @param HCWalletHistoryRepository $historyRepository
     */
    public function __construct(HCWalletRepository $walletRepository, HCWalletHistoryRepository $historyRepository)
    {
        $this->walletRepository = $walletRepository;
        $this->historyRepository = $historyRepository;
    }

    /**
     * Increase wallet balance
     *
     * @param float $amount
     * @param string $id
     * @param string $model
     * @param string $triggerId
     * @param string $triggerType
     * @return array
     * @throws BindingResolutionException
     * @throws EntryNotFoundException
     */
    public function increase(float $amount, string $id, string $model, string $triggerId, string $triggerType): array
    {
        $wallet = $this->getWallet($id, $model);

        // update balance
        $wallet->balance = $this->getCalculatedBalance($wallet->balance, $amount, $wallet->balance_debit);
        $wallet->save();

        $history = $this->createHistory($amount, $triggerId, $triggerType, $wallet);

        return ['success' => true, 'wallet' => $wallet, 'history' => $history];
    }

    /**
     * Decrease wallet balance
     *
     * @param float $amount
     * @param string $id
     * @param string $model
     * @param string $triggerId
     * @param string $triggerType
     * @return array
     * @throws BindingResolutionException
     * @throws EntryNotFoundException
     */
    public function decrease(float $amount, string $id, string $model, string $triggerId, string $triggerType): array
    {
        $wallet = $this->getWallet($id, $model);

        // convert amount to negative number
        $amount = -abs($amount);

        // update balance
        $wallet->balance = $this->getCalculatedBalance($wallet->balance, $amount, $wallet->balance_debit);
        $wallet->save();

        $history = $this->createHistory($amount, $triggerId, $triggerType, $wallet);

        return ['success' => true, 'wallet' => $wallet, 'history' => $history];
    }

    /**
     * Decrease wallet balance
     *
     * @param float $amount
     * @param string $id
     * @param string $model
     * @param string $triggerId
     * @param string $triggerType
     * @return array
     * @throws BindingResolutionException
     * @throws EntryNotFoundException
     */
    public function reserve(float $amount, string $id, string $model, string $triggerId, string $triggerType): array
    {
        $wallet = $this->getWallet($id, $model);

        // convert amount to negative number
        $amount = -abs($amount);

        // update balance
        $wallet->balance = $this->getCalculatedBalance($wallet->balance, $amount, $wallet->balance_debit);
        $wallet->save();

        $history = $this->createHistory($amount, $triggerId, $triggerType, $wallet);

        return ['success' => true, 'wallet' => $wallet, 'history' => $history];
    }

    /**
     * @param float $balance
     * @param float $amount
     * @param float $debitBalance
     * @return float
     * @throws \Exception
     */
    private function getCalculatedBalance(float $balance, float $amount, float $debitBalance): float
    {
        $balance = $balance + $amount;

        if ($balance < -abs($debitBalance)) {
            throw new WalletNotEnoughBalanceException(trans('ocv3payments::wallet.errors.not_enough_balance', [
                'balance' => $balance,
                'amount' => abs($amount),
            ]));
        }

        return $balance;
    }

    /**
     * Get wallet
     *
     * @param string $id
     * @param string $model
     * @return HCWallet
     * @throws BindingResolutionException
     * @throws EntryNotFoundException
     */
    private function getWallet(string $id, string $model): HCWallet
    {
        if (empty($id) || empty($model)) {
            throw new InvalidParameterException('Wallet params can\'t be empty');
        }

        $wallet = $this->walletRepository->makeQuery()->firstOrCreate([
            'ownable_id' => $id,
            'ownable_type' => $model,
        ], [
            'balance' => 0,
            'balance_debit' => config('wallet.debit_balance'),
        ]);

        return $wallet;
    }

    /**
     * @param float $amount
     * @param string $triggerId
     * @param string $triggerType
     * @param HCWallet $wallet
     * @return mixed
     * @throws BindingResolutionException
     */
    private function createHistory(float $amount, string $triggerId, string $triggerType, HCWallet $wallet)
    {
        $history = $this->historyRepository->create([
            'wallet_id' => $wallet->id,
            'balance' => $wallet->balance,
            'amount' => $amount,
            'action' => 'increase',
            'user_id' => auth()->id(),
            'transaction_id' => $triggerId,
            'transaction_type' => $triggerType,
        ]);

        return $history;
    }
}