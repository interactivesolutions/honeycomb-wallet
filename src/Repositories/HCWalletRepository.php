<?php

namespace InteractiveSolutions\HoneycombWallet\Repositories;

use InteractiveSolutions\HoneycombCore\Repositories\Repository;
use InteractiveSolutions\HoneycombWallet\Models\HCWallet;

class HCWalletRepository extends Repository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return HCWallet::class;
    }
}