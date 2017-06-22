# PHP Simple DotEnv
load enviroment vaiabled with PHP from a file in `.env` (dotenv) format. 

## Server Install
Download the repo and follow the steps below 
1. call simple_load_dotenv();
```
require_once('simple-dotenv.php');
simple_load_dotenv('/tmp/.env');
```
2. Here's a sample `/tmp/.env`, can follow any of the below formats
```
# <--- hashes or comments are ignored
# white spaces are ignored
DD_DATABASE_NAME = issm_lists_stage
# single and double quotes for values are allowed
DD_DATABASE_USER=dev
DD_DATABASE_PASSWD=dev
DD_DATABASE_HOST='192.168.33.1'
DD_DATABASE_PORT='3306'
DD_DATABASE_Type = "mysql"
```

Refferancing key a key to get teh value from the above `.env` files:

`echo $ENV{DD_DATABASE_HOST};`
output > `192.168.33.1`

#### Options
Accecpts two opitinal parameters
`full_dir_path` = (Optional) directory path to your dotevn file
`$name_of_dotenv` = (Optional) defaults to `.env` but can be overridden if you know it by a different name
```
NULL date ( [ string $full_dir_path ] [, string $name_of_dotenv='.env' ] )
```

Loading dotenv in this order. Once found it will stop searching for dotenv.
1. You pass the path of you dotenv file as a parameter `simple_load_dotenv('/tmp/.env');`
2. If you set a Perl accessable enviroment parameter `$ENV{DOTENV_FILE}` the subroutine will use the value of this vaiable. Use case would be defining in apache vhost configs like so
```
<VirtualHost hostname:80>
   ...
   SetEnv DOTENV_FILE /tmp/.env
   ...
</VirtualHost>
```
3. Generally when using Apache, the document root variable `$ENV{DOCUMENT_ROOT}`, is loaded into perl. if using HTTPD it will also search for `.env` in your document root. 
4. Finally we check in the currently directory the script is executed in `__DIR__`

