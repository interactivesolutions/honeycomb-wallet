<?php

Route::group(['prefix' => config('hc.admin_url'), 'middleware' => ['web', 'auth']], function ()
{
    Route::get('wallet/history', ['as' => 'admin.routes.wallet.history.index', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_list'], 'uses' => 'Wallet\\HCWalletHistoryController@adminIndex']);

    Route::group(['prefix' => 'api/wallet/history'], function ()
    {
        Route::get('/', ['as' => 'admin.api.routes.wallet.history', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_list'], 'uses' => 'Wallet\\HCWalletHistoryController@apiIndexPaginate']);
        Route::post('/', ['middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_create'], 'uses' => 'Wallet\\HCWalletHistoryController@apiStore']);
        Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_delete'], 'uses' => 'Wallet\\HCWalletHistoryController@apiDestroy']);

        Route::get('list', ['as' => 'admin.api.routes.wallet.history.list', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_list'], 'uses' => 'Wallet\\HCWalletHistoryController@apiIndex']);
        Route::post('restore', ['as' => 'admin.api.routes.wallet.history.restore', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_update'], 'uses' => 'Wallet\\HCWalletHistoryController@apiRestore']);
        Route::post('merge', ['as' => 'api.v1.routes.wallet.history.merge', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_create', 'acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_delete'], 'uses' => 'Wallet\\HCWalletHistoryController@apiMerge']);
        Route::delete('force', ['as' => 'admin.api.routes.wallet.history.force', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_force_delete'], 'uses' => 'Wallet\\HCWalletHistoryController@apiForceDelete']);

        Route::group(['prefix' => '{id}'], function ()
        {
            Route::get('/', ['as' => 'admin.api.routes.wallet.history.single', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_list'], 'uses' => 'Wallet\\HCWalletHistoryController@apiShow']);
            Route::put('/', ['middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_update'], 'uses' => 'Wallet\\HCWalletHistoryController@apiUpdate']);
            Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_delete'], 'uses' => 'Wallet\\HCWalletHistoryController@apiDestroy']);

            Route::put('strict', ['as' => 'admin.api.routes.wallet.history.update.strict', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_update'], 'uses' => 'Wallet\\HCWalletHistoryController@apiUpdateStrict']);
            Route::post('duplicate', ['as' => 'admin.api.routes.wallet.history.duplicate.single', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_list', 'acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_create'], 'uses' => 'Wallet\\HCWalletHistoryController@apiDuplicate']);
            Route::delete('force', ['as' => 'admin.api.routes.wallet.history.force.single', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_history_force_delete'], 'uses' => 'Wallet\\HCWalletHistoryController@apiForceDelete']);
        });
    });
});
