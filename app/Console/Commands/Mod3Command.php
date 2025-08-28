<?php

namespace App\Console\Commands;

use App\Mod3;
use Illuminate\Console\Command;

class Mod3Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mod3-command';

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
        $input = $this->ask('Enter binary integer string to get remainder');
        if (!$this->isStringBinary($input)) {
            $this->fail('Input is not a binary number');
        }

        $mod3 = new Mod3();
        $this->info('The remainder is ' . $mod3->run(binaryInteger: $input));
        return 0;
    }

    private function isStringBinary($stringNumber)
    {
        return preg_match('/^[01]+$/', $stringNumber) === 1;
    }
}