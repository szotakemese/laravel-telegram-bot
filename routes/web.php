<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    $response = Telegram::getMe();
    $botId = $response->getId();
    $firstName = $response->getFirstName();
    $username = $response->getUsername();
    echo $botId . '<br />' . $firstName . '<br />' . $username;
});

Route::post('/jkfbsgouaelkhsdofigrrhiogbipalbgoial/webhook', function () {
    $update = Telegram::commandsHandler(true);
    
    // Commands handler method returns an Update object.
    // So you can further process $update object 
    // to however you want.
    
    return 'ok';
});