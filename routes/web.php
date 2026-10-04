<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\StoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::post('/presence/heartbeat', 'HomeController@heartbeat')->name('presence.heartbeat');
    Route::get('/notifications/feed', 'HomeController@notificationFeed')->name('notifications.feed');
    Route::get('/chat-list', 'HomeController@chatList')->name('chat-list');
    Route::get('/entity-messages/{entity}', 'HomeController@entityMessages')->name('entity-messages.index');
    Route::get('/public-channel-messages/{entity}', 'HomeController@publicChannelMessages')->name('public-channel-messages');
    Route::post('/entity-messages/{entity}', 'HomeController@sendEntityMessage')->name('entity-messages.store');
    Route::post('/entity-messages/{message}/view', 'HomeController@markViewedEntityMessage')->name('entity-messages.view');
    Route::get('/entity-chats/{entity}', 'HomeController@chatMessages')->name('entity-chats.index');
    Route::post('/entity-chats/{entity}', 'HomeController@sendChatMessage')->name('entity-chats.store');
    Route::get('/search/users', 'HomeController@searchUsers')->name('search.users');
    Route::get('/messages/{user}', 'HomeController@messages')->name('messages.index');
    Route::post('/messages/{user}', 'HomeController@sendMessage')->name('messages.store');
    Route::delete('/messages/{message}', 'HomeController@deleteMessage')->name('messages.destroy');

Route::post('/messages/{user}/clear', 'HomeController@clearMessages')->name('messages.clear');
Route::post('/entity-messages/{entity}/clear', 'HomeController@clearEntityMessages')->name('entity-messages.clear');
Route::post('/entity-chats/{entity}/clear', 'HomeController@clearEntityChat')->name('entity-chats.clear');
Route::post('/entities/{entity}/leave', 'HomeController@leaveEntity')->name('entities.leave');

    Route::delete('/saved-messages/{message}', 'HomeController@deleteSavedMessage')->name('saved-messages.destroy');
    Route::get('/gifs/search', 'GifController@search')->name('gifs.search');
    Route::get('/saved-messages/data', 'HomeController@savedMessages')->name('saved-messages.data');
    Route::post('/saved-messages/data', 'HomeController@saveMessage')->name('saved-messages.store');
    Route::get('/profile/edit', [MenuController::class, 'profile'])->name('profile.edit');
    Route::patch('/profile/edit', [MenuController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/link-channel/search', [MenuController::class, 'searchProfileEntities'])->name('profile.link-channel.search');
    Route::post('/profile/link-channel', [MenuController::class, 'linkProfileEntity'])->name('profile.link-channel');
    Route::delete('/profile/link-channel/{entity}', [MenuController::class, 'unlinkProfileEntity'])->name('profile.unlink-channel');
    Route::get('/wallet', [MenuController::class, 'wallet'])->name('wallet');
    Route::get('/groups/create', [MenuController::class, 'group'])->name('groups.create');
    Route::get('/channels/create', [MenuController::class, 'channel'])->name('channels.create');

    // ---------- Chat Entities (kanal/guruh + ularga biriktirilgan suhbat) ----------
    Route::get('/chat-entities/{type}', [MenuController::class, 'chatEntities'])->name('chat-entities.index');
    Route::post('/chat-entities/{type}', [MenuController::class, 'storeChatEntity'])->name('chat-entities.store');
    Route::patch('/chat-entities/{type}/{id}', [MenuController::class, 'updateChatEntity'])->name('chat-entities.update');
    Route::post('/chat-entities/{type}/{id}/chat', [MenuController::class, 'storeChat'])->name('chat-entities.chat.store');
    Route::post('/chat-entities/{type}/{id}/chat/delete', [MenuController::class, 'deleteChat'])->name('chat-entities.chat.delete');
    Route::post('/chat-entities/{type}/{id}/delete', [MenuController::class, 'deleteChatEntity'])->name('chat-entities.delete');
    Route::post('/chat-entities/{type}/{id}/move-home', [MenuController::class, 'moveChatEntityHome'])->name('chat-entities.move-home');
    Route::delete('/chat-entities/{type}/{id}', [MenuController::class, 'destroyChatEntity'])->name('chat-entities.destroy');
    // --------------------------------------------------------------------------------

    Route::get('/contacts', [MenuController::class, 'contacts'])->name('contacts');
    Route::get('/calls', [MenuController::class, 'calls'])->name('calls');
    Route::get('/saved-messages', [MenuController::class, 'saved'])->name('saved');
    Route::get('/settings', [MenuController::class, 'settings'])->name('settings');
    Route::patch('/settings', [MenuController::class, 'updateSettings'])->name('settings.update');
    Route::get('/settings/export', [MenuController::class, 'exportData'])->name('settings.export');
    Route::post('/settings/logout-others', [MenuController::class, 'logoutOthers'])->name('settings.logout-others');
    Route::delete('/settings/account', [MenuController::class, 'deleteAccount'])->name('settings.delete-account');

    // Istoriyalar
    Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
    Route::delete('/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');
    Route::post('/stories/{story}/view', [StoryController::class, 'registerView'])->name('stories.view');
    Route::post('/stories/{story}/react', [StoryController::class, 'react'])->name('stories.react');
    Route::get('/users/{user}/stories', 'HomeController@userStories')->name('users.stories');
});

// Login/Logout — standart Laravel (email + parol)
Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

// Register — email kod bilan tasdiqlash (parol shu bosqichda kiritiladi)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/verify', [RegisteredUserController::class, 'verifyForm'])->name('verify.form');
    Route::post('/verify', [RegisteredUserController::class, 'verifyCode'])->name('verify.code');
});