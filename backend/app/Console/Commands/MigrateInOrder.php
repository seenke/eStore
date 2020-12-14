<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateInOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate_in_order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute migrations in the order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $migrations = [
            '2020_12_03_115743_create_post_offices_table.php',
            '2020_12_03_202658_create_roles_table.php',
            '2020_12_03_120039_create_store_items_table.php',
            '2014_10_12_000000_create_users_table.php',
            '2020_12_14_093059_create_shopping_carts_table.php',
            '2020_12_14_093746_create_shopping_cart_store_items_table.php',
            '2020_12_03_201541_create_user_accounts_table.php',
            '2020_12_03_115715_create_adresses_table.php',
            '2020_12_03_214556_create_statuses_table.php',
            '2020_12_03_115840_create_orders_table.php',
            '2020_12_04_093318_create_order_store_item_table.php',
            '2020_12_07_085437_create_pictures_table.php'
        ];

        foreach($migrations as $migration)
        {
            $basePath = 'database/migrations/';
            $migrationName = trim($migration);
            $path = $basePath.$migrationName;
            $this->call('migrate:refresh', [
                '--path' => $path ,
            ]);
        }

        return 0;
    }
}
