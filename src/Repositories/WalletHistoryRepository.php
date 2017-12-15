<?php

namespace InteractiveSolutions\HoneycombWallet\Repositories;

use InteractiveSolutions\HoneycombCore\Repositories\Repository;
use InteractiveSolutions\HoneycombWallet\Models\Wallet\HCWalletHistory;

class WalletHistoryRepository extends Repository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return HCWalletHistory::class;
    }
}