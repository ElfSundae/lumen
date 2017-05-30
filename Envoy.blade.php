
@servers(['web' => ['www@your-server']])

@setup
    $repo = 'git@github.com:ElfSundae/lumen-starter.git';
    $branch = isset($branch) ? $branch : 'master';
    $wwwRoot = '/data/www';
    $repoName = preg_replace('#\\.git$#i', '', pathinfo($repo, PATHINFO_BASENAME));
    $prefix = ($branch == 'master' ? '' : $branch.'-');
    $path = rtrim($wwwRoot, '/')."/{$prefix}{$repoName}";
@endsetup

@story('deploy')
    start
    lumen
    end
@endstory

@task('start')
    echo "====== Deploying [{{ $branch }}] to \"{{ $path }}\"..."
@endtask

@task('end')
    echo "====== Finished deploying \"{{ $repoName }}\"."
@endtask

@task('lumen')
    if [ ! -d "{{ $path }}" ]; then
        git clone {{ $repo }} --branch={{ $branch }} --single-branch --depth=1 "{{ $path }}"
        cd "{{ $path }}"
        composer install --no-scripts --no-dev --no-interaction --profile
        composer run-script post-root-package-install
        php -r "file_put_contents('.env', preg_replace('#((APP_ENV|APP_DEBUG)=.*)#', '# \$1', file_get_contents('.env')));"
        composer run-script post-create-project-cmd
        echo "====== Cloned repository! Please edit .env file."
        exit 0
    fi

    cd "{{ $path }}"

    if [ ! -f ".env" ]; then
        echo "====== [Error] There is no .env file."
        exit 1
    fi

    git pull origin {{ $branch }}

    composer install --optimize-autoloader --no-dev --no-interaction --profile
@endtask

@task('status')
    cd "{{ $path }}"
    git status
    echo "=========="
    git log -1 --color --graph --pretty=format:'%Cred%h%Creset -%C(yellow)%d%Creset %s %Cgreen(%cr) %C(bold blue)<%an>%Creset' --abbrev-commit
@endtask

@task('queue')
    cd "{{ $path }}"
    php artisan queue:restart
@endtask
