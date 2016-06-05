<?php

require 'recipe/laravel.php';

serverList('servers.yml');

set('keep_releases', 10);
set('repository', 'https://github.com/virtualabo/webapp-laravel');
set('shared_dirs', [
    'storage/logs',
    'storage/framework/sessions',
    'vendor',
    'node_modules',
]);
set('shared_files', [
    '.env'
]);

env('bin/npm', function() {
    return run('which npm')->toString();
});
env('npm_options', 'install');

task('deploy:node_modules', function() {
    $npm = env('bin/npm');
    $envVars = env('env_vars') ? 'export ' . env('env_vars') . ' &&' : '';

    run("cd {{release_path}} && $envVars $npm {{npm_options}}");
});
after('deploy:vendors', 'deploy:node_modules');
after('deploy', 'success');