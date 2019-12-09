# Scycop_home_task
Manto Makarevičiaus Scycop home task.

Console command was created using Artisan which is the command-line interface included with Laravel framework.
Artisan command 'make:command' was used to create a new command class called 'ReadACSVFile' which is located in SC/app/Console/Commands folder.

In the console navigate to the SC folder. Run command 'composer install' and enter command:

  php artisan csv:read test

where test is the name of the file with the example data.
The data from task.csv file will be read and a decision table will be applied in the ReadACSVFile.php file.

The main code:

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

        if(in_array($country, $EU) == 1){

          if($status == "Cancel"){

            if(intval($status_details) <= 14){
              $result = $result . " Y";
            }else{
              $result = $result . " N";
            }
          }elseif($status === "Delay"){

            if(intval($status_details) >= 3){
              $result = $result . " Y";
            }else{
              $result = $result . " N";
            }

          }
        }else{
          $result = $result . " N";
        }

        print "\n" . $result;

      }

      fclose($file_handle);
    }
