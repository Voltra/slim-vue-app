<?php


use App\Events\Events;
use App\Events\User\UserCreated;
use App\Events\User\UserLoggedIn;
use App\Events\User\UserLoggedOut;
use App\Events\User\UserLogListener;


/**********************************************************************************************************************\
 * User events
\**********************************************************************************************************************/
Events::on(UserCreated::class, [UserLogListener::class, "onCreate"]); // demo
Events::on(UserLoggedIn::class, [UserLogListener::class, "onLogin"]); // demo
Events::on(UserLoggedOut::class, [UserLogListener::class, "onLogout"]); // demo
