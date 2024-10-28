<?php

namespace Deployer;

desc('Move DotEnv Production to DotEnv and set shared.');
task('artisan:move-environment', function () {
    run("cp {{release_path}}/.env.production {{release_path}}/.env");
    set('shared_files', [ '.env' ]);
});
