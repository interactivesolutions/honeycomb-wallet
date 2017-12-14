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
 * E-mail: hello@interactivesolutions.lt
 * http://www.interactivesolutions.lt
 */

declare(strict_types = 1);

namespace InteractiveSolutions\HoneycombWallet\Forms\Wallet;

class HCWalletHistoryForm
{
    // name of the form
    protected $formID = 'wallet-history';

    // is form multi language
    protected $multiLanguage = 0;

    /**
     * Creating form
     *
     * @param bool $edit
     * @return array
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    public function createForm(bool $edit = false): array
    {
        $form = [
            'storageURL' => route('admin.api.routes.wallet.history'),
            'buttons'    => [
                [
                    "class" => "col-centered",
                    "label" => trans('HCTranslations::core.buttons.submit'),
                    "type"  => "submit",
                ],
            ],
            'structure'  => [
                [
    "type"            => "singleLine",
    "fieldID"         => "wallet_id",
    "label"           => trans("HCWallet::wallet_history.wallet_id"),
    "required"        => 1,
    "requiredVisible" => 1,
],[
    "type"            => "singleLine",
    "fieldID"         => "balance",
    "label"           => trans("HCWallet::wallet_history.balance"),
    "required"        => 1,
    "requiredVisible" => 1,
],[
    "type"            => "singleLine",
    "fieldID"         => "amount",
    "label"           => trans("HCWallet::wallet_history.amount"),
    "required"        => 1,
    "requiredVisible" => 1,
],[
    "type"            => "singleLine",
    "fieldID"         => "action",
    "label"           => trans("HCWallet::wallet_history.action"),
    "required"        => 1,
    "requiredVisible" => 1,
],[
    "type"            => "singleLine",
    "fieldID"         => "triggerable_id",
    "label"           => trans("HCWallet::wallet_history.triggerable_id"),
    "required"        => 0,
    "requiredVisible" => 0,
],[
    "type"            => "singleLine",
    "fieldID"         => "triggerable_type",
    "label"           => trans("HCWallet::wallet_history.triggerable_type"),
    "required"        => 0,
    "requiredVisible" => 0,
],
            ],
        ];

        if ($this->multiLanguage)
            $form['availableLanguages'] = getHCContentLanguages();

        if (!$edit)
            return $form;

        //Make changes to edit form if needed
        // $form['structure'][] = [];

        return $form;
    }
}