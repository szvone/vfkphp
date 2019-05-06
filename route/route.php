<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------



Route::any('getMenu', 'index/index/getMenu');
Route::any('getMe', 'index/index/getMe');
Route::any('login', 'index/index/login');
Route::any('loginOut', 'index/index/loginOut');



Route::any('getShop', 'index/index/getShop');
Route::any('getShopType', 'index/index/getShopType');


Route::any('getWebConfig', 'index/index/getWebConfig');




Route::any('buy', 'index/index/buy');
Route::any('payReturn', 'index/index/payReturn');
Route::any('payNotify', 'index/index/payNotify');


Route::any('getOrderContent', 'index/index/getOrderContent');
Route::any('getOrderByQQ', 'index/index/getOrderByQQ');
Route::any('getOrderById', 'index/index/getOrderById');



Route::any('checkPay', 'index/index/checkPay');


Route::any('closeOrder', 'index/index/clgq');


Route::any('admin/addShoptype', 'admin/index/addShoptype');
Route::any('admin/delShoptype', 'admin/index/delShoptype');
Route::any('admin/getShoptype', 'admin/index/getShoptype');
Route::any('admin/editShoptype', 'admin/index/editShoptype');

Route::any('admin/addShop', 'admin/index/addShop');
Route::any('admin/editShop', 'admin/index/editShop');
Route::any('admin/delShop', 'admin/index/delShop');
Route::any('admin/getShop', 'admin/index/getShop');
Route::any('admin/setShopstate', 'admin/index/setShopstate');
Route::any('admin/getShopByid', 'admin/index/getShopByid');

Route::any('admin/addKm', 'admin/index/addKm');
Route::any('admin/delKm', 'admin/index/delKm');
Route::any('admin/getKm', 'admin/index/getKm');
Route::any('admin/editKm', 'admin/index/editKm');
Route::any('admin/dcKm', 'admin/index/dcKm');

Route::any('admin/getOrder', 'admin/index/getOrder');

Route::any('admin/getSetting', 'admin/index/getSetting');
Route::any('admin/saveSetting', 'admin/index/saveSetting');


Route::any('admin/getMain', 'admin/index/getMain');




return [

];
