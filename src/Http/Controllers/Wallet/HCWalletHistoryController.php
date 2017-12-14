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

namespace InteractiveSolutions\HoneycombWallet\Http\Controllers\Wallet;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use InteractiveSolutions\HoneycombCore\Http\Controllers\HCBaseController;
use InteractiveSolutions\HoneycombWallet\Models\Wallet\HCWalletHistory;
use InteractiveSolutions\HoneycombWallet\Validators\Wallet\HCWalletHistoryValidator;

/**
 * Class HCWalletHistoryController
 * @package InteractiveSolutions\HoneycombWallet\Http\Controllers\Wallet
 */
class HCWalletHistoryController extends HCBaseController
{
    //TODO recordsPerPage setting

    /**
     * Returning configured admin view
     *
     * @return View
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    public function adminIndex(): View
    {
        $config = [
            'title'       => trans('HCWallet::wallet_history.page_title'),
            'listURL'     => route('admin.api.routes.wallet.history'),
            'newFormUrl'  => route('admin.api.form-manager', ['wallet-history-new']),
            'editFormUrl' => route('admin.api.form-manager', ['wallet-history-edit']),
            'imagesUrl'   => route('resource.get', ['/']),
            'headers'     => $this->getAdminListHeader(),
        ];

        if (auth()->user()->can('interactivesolutions_honeycomb_wallet_routes_wallet_history_create')) {
            $config['actions'][] = 'new';
        }

        if (auth()->user()->can('interactivesolutions_honeycomb_wallet_routes_wallet_history_update')) {
            $config['actions'][] = 'update';
            $config['actions'][] = 'restore';
        }

        if (auth()->user()->can('interactivesolutions_honeycomb_wallet_routes_wallet_history_delete')) {
            $config['actions'][] = 'delete';
        }

        $config['actions'][] = 'search';
        $config['filters'] = $this->getFilters ();

        return hcview('HCCoreUI::admin.content.list', ['config' => $config]);
    }

    /**
     * Creating Admin List Header based on Main Table
     *
     * @return array
     */
    public function getAdminListHeader(): array
    {
        return [
            'wallet_id'     => [
    "type"  => "text",
    "label" => trans('HCWallet::wallet_history.wallet_id'),
],
'balance'     => [
    "type"  => "text",
    "label" => trans('HCWallet::wallet_history.balance'),
],
'amount'     => [
    "type"  => "text",
    "label" => trans('HCWallet::wallet_history.amount'),
],
'action'     => [
    "type"  => "text",
    "label" => trans('HCWallet::wallet_history.action'),
],
'triggerable_id'     => [
    "type"  => "text",
    "label" => trans('HCWallet::wallet_history.triggerable_id'),
],
'triggerable_type'     => [
    "type"  => "text",
    "label" => trans('HCWallet::wallet_history.triggerable_type'),
],

        ];
    }

    /**
     * Getting single record
     *
     * @param $id
     * @return mixed
     */
    public function apiShow(string $id)
    {
        $with = [];

        $select = HCWalletHistory::getFillableFields();

        $record = HCWalletHistory::with($with)
            ->select($select)
            ->where('id', $id)
            ->firstOrFail();

        return $record;
    }

    /**
     * Generating filters required for admin view
     *
     * @return array
     */
    public function getFilters(): array
    {
        $filters = [];

        return $filters;
    }

    /**
     * Getting user data on POST call
     *
     * @return mixed
     */
    protected function getInputData(): array
    {
        (new HCWalletHistoryValidator())->validateForm();

        $_data = request()->all();

        if (array_has($_data, 'id'))
            array_set ($data, 'record.id', array_get ($_data, 'id'));

        array_set($data, 'record.wallet_id', array_get($_data, 'wallet_id'));
array_set($data, 'record.balance', array_get($_data, 'balance'));
array_set($data, 'record.amount', array_get($_data, 'amount'));
array_set($data, 'record.action', array_get($_data, 'action'));
array_set($data, 'record.triggerable_id', array_get($_data, 'triggerable_id'));
array_set($data, 'record.triggerable_type', array_get($_data, 'triggerable_type'));

        return makeEmptyNullable($data);
    }

        /**
     * Create item
     *
     * @return mixed
     * @throws \Exception
     */
    protected function __apiStore()
    {
        $data = $this->getInputData();

        $record = HCWalletHistory::create(array_get($data, 'record'));

        return $this->apiShow($record->id);
    }

    /**
     * Updates existing item based on ID
     *
     * @param string $id
     * @return mixed
     * @throws \Exception
     */
    protected function __apiUpdate(string $id)
    {
        $record = HCWalletHistory::findOrFail($id);

        $data = $this->getInputData();

        $record->update(array_get($data, 'record', []));

        return $this->apiShow($record->id);
    }

    /**
     * Updates existing specific items based on ID
     *
     * @param string $id
     * @return mixed
     */
    protected function __apiUpdateStrict(string $id)
    {
        HCWalletHistory::where('id', $id)->update(request()->all());

        return $this->apiShow($id);
    }

    /**
     * Delete records table
     *
     * @param $list
     * @return mixed
     */
    protected function __apiDestroy(array $list)
    {
        HCWalletHistory::destroy($list);

        return hcSuccess();
    }

    /**
     * Delete records table
     *
     * @param $list
     * @return mixed
     */
    protected function __apiForceDelete(array $list)
    {
        HCWalletHistory::onlyTrashed()->whereIn('id', $list)->forceDelete();

        return hcSuccess();
    }

    /**
     * Restore multiple records
     *
     * @param $list
     * @return mixed
     */
    protected function __apiRestore(array $list)
    {
        HCWalletHistory::whereIn('id', $list)->restore();

        return hcSuccess();
    }

    /**
     * Creating data query
     *
     * @param array $select
     * @return mixed
     */
    protected function createQuery(array $select = null)
    {
        $with = [];

        if ($select == null)
            $select = HCWalletHistory::getFillableFields();

        $list = HCWalletHistory::with($with)->select($select)
        // add filters
        ->where(function ($query) use ($select) {
            $query = $this->getRequestParameters($query, $select);
        });

        // enabling check for deleted
        $list = $this->checkForDeleted($list);

        // add search items
        $list = $this->search($list);

        // ordering data
        $list = $this->orderData($list, $select);

        return $list;
    }

    /**
     * List search elements
     * @param Builder $query
     * @param string $phrase
     * @return Builder
     */
    protected function searchQuery(Builder $query, string $phrase): Builder
    {
        return $query->where (function (Builder $query) use ($phrase) {
                $query->where('wallet_id', 'LIKE', '%' . $phrase . '%')
->orWhere('balance', 'LIKE', '%' . $phrase . '%')
->orWhere('amount', 'LIKE', '%' . $phrase . '%')
->orWhere('action', 'LIKE', '%' . $phrase . '%')
->orWhere('triggerable_id', 'LIKE', '%' . $phrase . '%')
->orWhere('triggerable_type', 'LIKE', '%' . $phrase . '%')
;
             });
    }

}
