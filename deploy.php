<?php
namespace Deployer;

require 'recipe/laravel.php';

// vendor/bin/dep deploy production

// Project name
set('application', 'study');

// Project repository
set('repository', 'https://github.com/ult-shimizu/study.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys
//ログファイルなどバージョンをまたいで共有したいファイルやディレクトリ
//ここで指定したファイルやディレクトリはデプロイ後に shared_dirs に格納され、
//バージョン間で共有することができるようになります。
//recipe/laravel.phpで設定されているため、とくに設定はしない
//add('shared_files', [
//    '.env'
//]);
//add('shared_dirs', [
//    'storage',
//]);

// Writable dirs by web server 
//add('writable_dirs', []);


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
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

