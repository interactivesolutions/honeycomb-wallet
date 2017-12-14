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

