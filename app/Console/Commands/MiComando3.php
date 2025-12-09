<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MiComando3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:mi-comando3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $this->info('¡Hola desde mi comando TERCER de Laravel!'); // Texto informativo
        // O también puedes usar:
        // $this->line('Este es un texto de ejemplo.'); // Texto normal
    }
}
