<?php return array (
  'beyondcode/laravel-websockets' => 
  array (
    'providers' => 
    array (
      0 => 'BeyondCode\\LaravelWebSockets\\WebSocketsServiceProvider',
    ),
    'aliases' => 
    array (
      'WebSocketRouter' => 'BeyondCode\\LaravelWebSockets\\Facades\\WebSocketRouter',
    ),
  ),
  'jenssegers/mongodb' => 
  array (
    'providers' => 
    array (
      0 => 'Jenssegers\\Mongodb\\MongodbServiceProvider',
      1 => 'Jenssegers\\Mongodb\\MongodbQueueServiceProvider',
    ),
  ),
  'laracasts/utilities' => 
  array (
    'providers' => 
    array (
      0 => 'Laracasts\\Utilities\\JavaScript\\JavaScriptServiceProvider',
    ),
    'aliases' => 
    array (
      'JavaScript' => 'Laracasts\\Utilities\\JavaScript\\JavaScriptFacade',
    ),
  ),
  'laravel-frontend-presets/light-bootstrap' => 
  array (
    'providers' => 
    array (
      0 => 'LaravelFrontendPresets\\LightBootstrapPreset\\LightBootstrapPresetServiceProvider',
    ),
  ),
  'laravel/horizon' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Horizon\\HorizonServiceProvider',
    ),
    'aliases' => 
    array (
      'Horizon' => 'Laravel\\Horizon\\Horizon',
    ),
  ),
  'laravel/legacy-factories' => 
  array (
    'providers' => 
    array (
      0 => 'Illuminate\\Database\\Eloquent\\LegacyFactoryServiceProvider',
    ),
  ),
  'laravel/sail' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Sail\\SailServiceProvider',
    ),
  ),
  'laravel/sanctum' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Sanctum\\SanctumServiceProvider',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'laravel/ui' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Ui\\UiServiceProvider',
    ),
  ),
  'laravelcollective/html' => 
  array (
    'providers' => 
    array (
      0 => 'Collective\\Html\\HtmlServiceProvider',
    ),
    'aliases' => 
    array (
      'Form' => 'Collective\\Html\\FormFacade',
      'Html' => 'Collective\\Html\\HtmlFacade',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'spatie/laravel-ignition' => 
  array (
    'providers' => 
    array (
      0 => 'Spatie\\LaravelIgnition\\IgnitionServiceProvider',
    ),
    'aliases' => 
    array (
      'Flare' => 'Spatie\\LaravelIgnition\\Facades\\Flare',
    ),
  ),
);