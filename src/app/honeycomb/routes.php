<?php

//interactivesolutions/honeycomb-wallet/src/Routes/Admin/01_routes.wallet.php


Route::group(['prefix' => config('hc.admin_url'), 'middleware' => ['web', 'auth']], function ()
{
    Route::get('wallet', ['as' => 'admin.routes.wallet.index', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_list'], 'uses' => 'HCWalletController@adminIndex']);

    Route::group(['prefix' => 'api/wallet'], function ()
    {
        Route::get('/', ['as' => 'admin.api.routes.wallet', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_list'], 'uses' => 'HCWalletController@apiIndexPaginate']);
        Route::post('/', ['middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_create'], 'uses' => 'HCWalletController@apiStore']);
        Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_delete'], 'uses' => 'HCWalletController@apiDestroy']);

        Route::get('list', ['as' => 'admin.api.routes.wallet.list', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_list'], 'uses' => 'HCWalletController@apiIndex']);
        Route::post('restore', ['as' => 'admin.api.routes.wallet.restore', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_update'], 'uses' => 'HCWalletController@apiRestore']);
        Route::post('merge', ['as' => 'api.v1.routes.wallet.merge', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_create', 'acl:interactivesolutions_honeycomb_wallet_routes_wallet_delete'], 'uses' => 'HCWalletController@apiMerge']);
        Route::delete('force', ['as' => 'admin.api.routes.wallet.force', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_force_delete'], 'uses' => 'HCWalletController@apiForceDelete']);

        Route::group(['prefix' => '{id}'], function ()
        {
            Route::get('/', ['as' => 'admin.api.routes.wallet.single', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_list'], 'uses' => 'HCWalletController@apiShow']);
            Route::put('/', ['middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_update'], 'uses' => 'HCWalletController@apiUpdate']);
            Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_delete'], 'uses' => 'HCWalletController@apiDestroy']);

            Route::put('strict', ['as' => 'admin.api.routes.wallet.update.strict', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_update'], 'uses' => 'HCWalletController@apiUpdateStrict']);
            Route::post('duplicate', ['as' => 'admin.api.routes.wallet.duplicate.single', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_list', 'acl:interactivesolutions_honeycomb_wallet_routes_wallet_create'], 'uses' => 'HCWalletController@apiDuplicate']);
            Route::delete('force', ['as' => 'admin.api.routes.wallet.force.single', 'middleware' => ['acl:interactivesolutions_honeycomb_wallet_routes_wallet_force_delete'], 'uses' => 'HCWalletController@apiForceDelete']);
        });
    });
});



//interactivesolutions/honeycomb-wallet/src/Routes/Admin/02_routes.wallet.history.php


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



//interactivesolutions/honeycomb-wallet/src/Routes/Api/01_routes.wallet.php


Route::group(['prefix' => 'api', 'middleware' => ['auth-apps']], function ()
{
    Route::group(['prefix' => 'v1/wallet'], function ()
    {
        Route::get('/', ['as' => 'api.v1.routes.wallet', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_list'], 'uses' => 'HCWalletController@apiIndexPaginate']);
        Route::post('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_create'], 'uses' => 'HCWalletController@apiStore']);
        Route::delete('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_delete'], 'uses' => 'HCWalletController@apiDestroy']);

        Route::group(['prefix' => 'list'], function ()
        {
            Route::get('/', ['as' => 'api.v1.routes.wallet.list', 'middleware' => ['acl-apps:api_v1_interactivesolutions_honeycomb_wallet_routes_wallet_list'], 'uses' => 'HCWalletController@apiList']);
            Route::get('{timestamp}', ['as' => 'api.v1.routes.wallet.list.update', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_list'], 'uses' => 'HCWalletController@apiIndexSync']);
        });

        Route::post('restore', ['as' => 'api.v1.routes.wallet.restore', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_update'], 'uses' => 'HCWalletController@apiRestore']);
        Route::post('merge', ['as' => 'api.v1.routes.wallet.merge', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_create', 'acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_delete'], 'uses' => 'HCWalletController@apiMerge']);
        Route::delete('force', ['as' => 'api.v1.routes.wallet.force', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_force_delete'], 'uses' => 'HCWalletController@apiForceDelete']);

        Route::group(['prefix' => '{id}'], function ()
        {
            Route::get('/', ['as' => 'api.v1.routes.wallet.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_list'], 'uses' => 'HCWalletController@apiShow']);
            Route::put('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_update'], 'uses' => 'HCWalletController@apiUpdate']);
            Route::delete('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_delete'], 'uses' => 'HCWalletController@apiDestroy']);

            Route::put('strict', ['as' => 'api.v1.routes.wallet.update.strict', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_update'], 'uses' => 'HCWalletController@apiUpdateStrict']);
            Route::post('duplicate', ['as' => 'api.v1.routes.wallet.duplicate.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_list', 'acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_create'], 'uses' => 'HCWalletController@apiDuplicate']);
            Route::delete('force', ['as' => 'api.v1.routes.wallet.force.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_wallet_routes_wallet_force_delete'], 'uses' => 'HCWalletController@apiForceDelete']);
        });
    });
});


//interactivesolutions/honeycomb-wallet/src/Routes/Api/02_routes.wallet.history.php


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

