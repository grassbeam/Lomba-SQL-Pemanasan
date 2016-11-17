#Front-End Grader for Lomba SQL (Warming Up Session)
- [Front-End for Competition](https://github.com/grassbeam/Lomba-SQL "Front-End") 
- [Front-End for Warming Up Session](https://github.com/grassbeam/Lomba-SQL-Pemanasan "Front-End Warming Up Session") 
- [Back-End for All](https://github.com/grassbeam/Lomba-SQL-Back-End "Back-End") 


##How to use:
- create table in  [myconnection.sql](/dbsql/myconnection.sql)
- set connection name + username and password
- change $query[] to your problem set [importsoal.php](/cpanel/model/importsoal.php)
- try open [index page](/index.php) 
  if error on oci_connect checkout for oracle instantclient 
  check oci8 in PHP.ini file, remove ';' before oci8
  download version based on PHP.ini (11.1 for 11g / 12.0 for 12g)  and add to PATH in environtment variable
  restart everything!
- create CSV File for contestant name and school name without header table [ [data example] (/dbsql/IMPORT.csv) ]
- open [import page](/cpanel/import.php)
- import CSV file and wait for username and password table
- try login
- run back end and finished...

>>Watch scoreboard from [cpanel](/cpanel/index.php)
