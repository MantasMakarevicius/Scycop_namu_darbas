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
      //
      // echo "hi, $fileName. You know maybe we'll do it...somehow...";

      $file_handle = fopen("$fileName.csv", "r");
      // echo "file name is: $file_handle\n";

      $EU = [
             'BE','EL','LT','PT','BG','ES','LU',
             'RO','CZ','FR','HU','SI','DK','HR',
             'MT','SK','DE','IT','NL','FI','EE',
             'CY','AT','SE','IE','LV','PL','UK'
           ];

      while (!feof($file_handle) ) {

        $line_of_text = fgetcsv($file_handle, 100);

        // print $line_of_text[0] . $line_of_text[1]. $line_of_text[2] . "\n";
        $country = $line_of_text[0];
        $status = substr($line_of_text[1], 1, strlen($line_of_text[1])+1);
        $status_details = $line_of_text[2];

        $string = $line_of_text[0] . $line_of_text[1]. $line_of_text[2];

        if(in_array($country, $EU) == 1){

          if($status == "Cancel"){

            if(intval($status_details) <= 14){
              $string = $string . " Y";
            }else{
              $string = $string . " N";
            }
          }elseif($status === "Delay"){

            if(intval($status_details) >= 3){
              $string = $string . " Y";
            }else{
              $string = $string . " N";
            }

          }
        }else{
          $string = $string . " N";
        }

        print "\n" . $string;

      }

      fclose($file_handle);
    }
}
