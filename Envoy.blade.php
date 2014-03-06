@servers(['web' => 'vagrant@10.0.2.15'])
@task('mail', ['on' => 'web'])
    cd /vagrant
    php artisan queue:listen
@endtask