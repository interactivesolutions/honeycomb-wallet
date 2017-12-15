<?php
/**
 * @copyright 2017 interactivesolutions
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * Contact InteractiveSolutions:
 * E-mail: info@interactivesolutions.lt
 * http://www.interactivesolutions.lt
 */

declare(strict_types = 1);

namespace Tests\Unit\Services;

use Faker\Generator as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use InteractiveSolutions\HoneycombAcl\Models\HCUsers;
use InteractiveSolutions\HoneycombWallet\Exceptions\WalletNotEnoughBalanceException;
use InteractiveSolutions\HoneycombWallet\Models\HCWallet;
use InteractiveSolutions\HoneycombWallet\Models\Wallet\HCWalletHistory;
use InteractiveSolutions\HoneycombWallet\Services\HCWalletBalanceService;
use Tests\TestCase;

class HCWalletBalanceServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->factory->define(HCUsers::class, function(Faker $faker) {
            static $password;

            return [
                'email' => $faker->email,
                'password' => $password ?: $password = bcrypt('secret'),
                'remember_token' => str_random(10),
                'last_visited' => $faker->dateTime,
            ];
        });

        $this->factory->define(HCWallet::class, function(Faker $faker) {
            return [
                'balance' => rand(1, 1000),
                'balance_debit' => 0,
                'ownable_id' => function() {
                    return factory(HCUsers::class)->create()->id;
                },
                'ownable_type' => HCUsers::class,
            ];
        });
    }

    /** @test */
    public function increase_method_must_return_success_on_creating_wallet(): void
    {
        $wallet = factory(HCWallet::class)->create();

        $increaseAmount = 20;

        $response = $this->getServiceInstance()->increase($increaseAmount, $wallet->ownable_id, $wallet->ownable_type);

        $this->assertTrue($response['success']);

        $this->assertTrue($response['wallet'] instanceof HCWallet);

        $this->assertTrue($response['history'] instanceof HCWalletHistory);

        $this->assertEquals($wallet->balance + $increaseAmount, $response['wallet']->balance);

        $this->assertEquals(0, $response['wallet']->balance_debit);

        $this->assertEquals($wallet->ownable_id, $response['wallet']->ownable_id);

        $this->assertEquals($wallet->ownable_type, $response['wallet']->ownable_type);
    }

    /** @test */
    public function it_must_throw_exception_when_wallet_balance_is_lower_than_given_amount(): void
    {
        $this->expectException(WalletNotEnoughBalanceException::class);

        $this->expectExceptionMessage(trans('HCWallet::wallet.errors.not_enough_amount', [
            'balance' => 10,
            'amount' => 20,
        ]));

        $wallet = factory(HCWallet::class)->create([
            'balance' => 10,
        ]);

        $this->getServiceInstance()->decrease(20, $wallet->ownable_id, $wallet->ownable_type);
    }

    /** @test */
    public function it_must_return_success_when_decreasing_from_wallet_with_valid_amount()
    {
        $wallet = factory(HCWallet::class)->create(['balance' => 10]);

        $reduceAmount = 5;

        $response = $this->getServiceInstance()->decrease($reduceAmount, $wallet->ownable_id, $wallet->ownable_type);

        $this->assertTrue($response['success']);

        $this->assertEquals($reduceAmount, $response['wallet']->balance);

        $this->assertEquals(0, $response['wallet']->balance_debit);
    }

    /** @test */
    public function it_must_return_success_when_decreasing_from_wallet_with_valid_amount_and_with_balance_debit()
    {
        $wallet = factory(HCWallet::class)->create(['balance' => 0, 'balance_debit' => 20]);

        $reduceAmount = 15;

        $response = $this->getServiceInstance()->decrease($reduceAmount, $wallet->ownable_id, $wallet->ownable_type);

        $this->assertTrue($response['success']);

        $this->assertEquals($wallet->balance - $reduceAmount, $response['wallet']->balance);

        $this->assertEquals(20, $response['wallet']->balance_debit);
    }


    /** @test */
    public function it_must_return_success_when_increasing_balance_from_minus_balance()
    {
        $wallet = factory(HCWallet::class)->create(['balance' => -20, 'balance_debit' => 20]);

        $increaseAmount = 15;

        $response = $this->getServiceInstance()->increase($increaseAmount, $wallet->ownable_id, $wallet->ownable_type);

        $this->assertTrue($response['success']);

        $this->assertEquals($wallet->balance + $increaseAmount, $response['wallet']->balance);

        $this->assertEquals(20, $response['wallet']->balance_debit);
    }

    // TODO add tests with wallet history


    /**
     * @return HCWalletBalanceService
     */
    private function getServiceInstance(): HCWalletBalanceService
    {
        return $this->app->make(HCWalletBalanceService::class);
    }
}