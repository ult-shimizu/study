<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'study');

// Project repository
set('repository', 'git@https://github.com/ult-shimizu/study.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts

inventory('hosts.yml');
    
// Tasks

task('deploy:laravel', [
        'deploy:info',
        'deploy:prepare',
        'deploy:lock',
        'deploy:release',
        'deploy:update_code',
        'deploy:shared',
        'deploy:vendors',
        'deploy:writable',
        'artisan:storage:link',
        'artisan:view:clear',
        'artisan:cache:clear',
        'artisan:config:cache',
        'artisan:optimize',
        'deploy:symlink',
        'deploy:unlock',
        'cleanup',
    ]
);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:
unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

