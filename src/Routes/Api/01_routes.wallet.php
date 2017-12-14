<?php

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