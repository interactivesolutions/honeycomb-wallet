<?php

Route::group(['prefix' => 'api', 'middleware' => ['auth-apps']], function ()
{
    Route::group(['prefix' => 'v1/wallet/history'], function ()
    {
        Route::get('/', ['as' => 'api.v1.routes.wallet.history', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_list'], 'uses' => 'Wallet\\HCWalletHistoryController@apiIndexPaginate']);
        Route::post('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_create'], 'uses' => 'Wallet\\HCWalletHistoryController@apiStore']);
        Route::delete('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_delete'], 'uses' => 'Wallet\\HCWalletHistoryController@apiDestroy']);

        Route::group(['prefix' => 'list'], function ()
        {
            Route::get('/', ['as' => 'api.v1.routes.wallet.history.list', 'middleware' => ['acl-apps:api_v1_interactivesolutions_honeycomb_wallet_routes_wallet_history_list'], 'uses' => 'Wallet\\HCWalletHistoryController@apiList']);
            Route::get('{timestamp}', ['as' => 'api.v1.routes.wallet.history.list.update', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_list'], 'uses' => 'Wallet\\HCWalletHistoryController@apiIndexSync']);
        });

        Route::post('restore', ['as' => 'api.v1.routes.wallet.history.restore', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_update'], 'uses' => 'Wallet\\HCWalletHistoryController@apiRestore']);
        Route::post('merge', ['as' => 'api.v1.routes.wallet.history.merge', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_create', 'acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_delete'], 'uses' => 'Wallet\\HCWalletHistoryController@apiMerge']);
        Route::delete('force', ['as' => 'api.v1.routes.wallet.history.force', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_force_delete'], 'uses' => 'Wallet\\HCWalletHistoryController@apiForceDelete']);

        Route::group(['prefix' => '{id}'], function ()
        {
            Route::get('/', ['as' => 'api.v1.routes.wallet.history.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_list'], 'uses' => 'Wallet\\HCWalletHistoryController@apiShow']);
            Route::put('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_update'], 'uses' => 'Wallet\\HCWalletHistoryController@apiUpdate']);
            Route::delete('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_delete'], 'uses' => 'Wallet\\HCWalletHistoryController@apiDestroy']);

            Route::put('strict', ['as' => 'api.v1.routes.wallet.history.update.strict', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_update'], 'uses' => 'Wallet\\HCWalletHistoryController@apiUpdateStrict']);
            Route::post('duplicate', ['as' => 'api.v1.routes.wallet.history.duplicate.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_list', 'acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_create'], 'uses' => 'Wallet\\HCWalletHistoryController@apiDuplicate']);
            Route::delete('force', ['as' => 'api.v1.routes.wallet.history.force.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_history_force_delete'], 'uses' => 'Wallet\\HCWalletHistoryController@apiForceDelete']);
        });
    });
});