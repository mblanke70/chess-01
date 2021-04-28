<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\Message;
use App\Events\MessageSent;

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
    
    $messages = Message::with('user')->get();

    return view('chat', [
        'messages' => $messages,
    ]);
});

Route::post('/sendMessage', function(Request $request) {

    $user = Auth::user();

    $message = new Message;
    $message->message = $request->input('message');
    
    $user->messages()->save($message);

    event(new App\Events\MessageSent($message->message));

    return redirect('/');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
