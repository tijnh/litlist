<?php

ini_set("session.use_only_cookies", 1);
ini_set("session.use_strict_mode", 1);

// These lines enable user to go back to previous page with POST request without errors
ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);

set_session_cookie_params();

session_start();

// Regenerate session id every 30 minutes
if (!isset($_SESSION["last_regeneration"])) {
  regenerate_session_id();
} else {
  $interval = 60 * 30;
  if (time() - $_SESSION["last_regeneration"] >= $interval) {
    regenerate_session_id();
  }
}

function set_session_cookie_params($lifetime = 0, $domain = DBHOST, $path = "/", $secure = true, $httponly = true)
{
  session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
}


function regenerate_session_id()
{
  session_regenerate_id(true);
  $_SESSION["last_regeneration"] = time();
}
