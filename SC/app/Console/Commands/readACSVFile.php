<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class readACSVFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:read {fileName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read a .csv file and apply a decision table.';

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
     * @return mixed
     */
    public function handle()
    {
      $fileName = $this->argument('fileName');
      
      $file_handle = fopen("$fileName.csv", "r");

      $EU = [
             'BE','EL','LT','PT','BG','ES','LU',
             'RO','CZ','FR','HU','SI','DK','HR',
             'MT','SK','DE','IT','NL','FI','EE',
             'CY','AT','SE','IE','LV','PL','UK'
           ];

      while (!feof($file_handle) ) {

        $line_of_text = fgetcsv($file_handle, 100);

        $country = $line_of_text[0];
        $status = substr($line_of_text[1], 1, strlen($line_of_text[1])+1);
        $status_details = $line_of_text[2];

        $result = $line_of_text[0] . $line_of_text[1]. $line_of_text[2];

        if(in_array($country, $EU)){

          if($status == "Cancel"){

            if(intval($status_details) <= 14){
              $result = $result . " Y";
            } else{
              $result = $result . " N";
            }

          } else if($status == "Delay"){

            if(intval($status_details) >= 3){
              $result = $result . " Y";
            } else{
              $result = $result . " N";
            }

          }
        } else{
          $result = $result . " N";
        }

        print "\n" . $result;

      }

      fclose($file_handle);
    }
}
