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

namespace Tests;


use Illuminate\Database\Eloquent\Factory;
use Illuminate\Foundation\Application;
use InteractiveSolutions\HoneycombAcl\Providers\HCACLServiceProvider;
use InteractiveSolutions\HoneycombCore\Providers\HCCoreServiceProvider;
use interactivesolutions\honeycomblanguages\app\providers\HCLanguagesServiceProvider;
use InteractiveSolutions\HoneycombScripts\app\providers\HCScriptsServiceProvider;
use InteractiveSolutions\HoneycombWallet\Providers\HCWalletServiceProvider;

/**
 * Class TestCase
 * @package Tests
 */
abstract class TestCase extends \Orchestra\Testbench\BrowserKit\TestCase
{
    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();

        $this->factory = $this->app->make(Factory::class);

    }

    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            HCCoreServiceProvider::class,
            HCACLServiceProvider::class,
            HCLanguagesServiceProvider::class,
            HCScriptsServiceProvider::class,
            HCWalletServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        config([
            'wallet.debit_balance' => '0',
        ]);
    }
}