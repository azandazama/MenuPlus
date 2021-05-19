# MenuPlus

[Ussd](https://en.wikipedia.org/wiki/Unstructured_Supplementary_Service_Data) is an amazing technology for anyone looking to create apps which can reach a large volume of people. Ussd is an ancient technology yet it still serves a purpose in our day and age. This PHP library simplies the process behind creating said apps with the [AAT Mobile Ussd API](https://www.aat.co.za/always-active-mobile/ussd/)

Read more about MenuPlus:

- [Requirements](#requirements)
- [Installation](#installation)
- [Ussd Menus](#ussd-menus)
- [Getting Started](#getting-started)
- [Author](#author)
- [License](#license)


## Requirements

In order for you to use MenuPlus you need to set up an account with [AAT Mobile](https://www.aat.co.za/always-active-mobile/ussd/) for ussd, after which you can require this library and code away 👨🏽‍💻

## Installation

MenuPlus is installed via [Composer](https://getcomposer.org/).

```bash
composer require azandazama/menuplus
```

You can of course also manually edit your composer.json file

```bash
{
    "require": {
        "azandazama/menuplus": "^1.0"
    }
}
```

## Ussd Menus

*MenuPlus* offers different types of ussd menus which serve different purposes. Code and screenshots will be shown below.

### Standard Menu
This menu has all the bells and whistles offering you with unlimited options and option urls. [screenshot](https://ztdev.co.za)


```php
$ussd->title = 'Welcome to the Example Ussd Platform!';
$ussd->options = ['Option 1', 'Option 2', 'Option 3'];
$ussd->option_url = ['index.php?page=1', 'index.php?page=2', 'index.php?page=3'];
echo $ussd->addMenu($url);
```

Options have URLs( `$ussd->option_url` ) and you can consider Options( `$ussd->options` ) as links and menus as pages. Options and Option URLs are parallel arrays and each option corrisponds to each option URL


### Free Text Menu
This menu has no options and the title is therefore considered as the option. [screenshot](https://ztdev.co.za)

```php
$ussd->title = 'Please provide first and last name';
$ussd->option_url = 'index.php?file=4';
echo $ussd->addMenu($url);
```

### Paginated Menu
This menu offers all the bells and whistles and also allows you to order your menu with pagination

```php
$ussd->title = 'Select an option';
$ussd->options = ['Option 1', 'Option 2', 'Option 3', 'Option 4', 'Option 5', 'Option 6', 'Option 7'];
// Menu options can all share the same url
$ussd->option_url = 'index.php?page=5';
// [3] is the amount of options that will be shown in this menu
return $ussd->paginateMenu($url, 3);
```


## Getting Started

The following is a basic usage example of the MenuPlus library.

```php
<?php
require_once './vendor/autoload.php';

$ussd = new \MenuPlus\Ussd;
// ensure your url ends with a backslash
$url = 'http://localhost:7000/';

function initMenu($ussd, $url)
{
    switch(@$_GET['page'])
    {
        case '':
            // This is the first menu the application will serve
            $ussd->title = 'Welcome to the Example Ussd Platform!';
            $ussd->options = ['Questionnaire', 'Register', 'Shows available', 'Exit'];
            $ussd->option_url = ['index.php?page=1', 'index.php?page=2', 'index.php?page=3', 'index.php?page=4', 'index.php?page=exit'];
            return $ussd->addMenu($url);
        break;
        case 1: 
            $ussd->title = 'What year was Nelson Mandela born';
            $ussd->options = ['1900', '1918', 'Back'];
            $ussd->option_url = ['index.php?page=answer&ans=wrong', 'index.php?page=answer&ans=correct', 'index.php'];
            return $ussd->addMenu($url);
        break;
        case 2:
            // FreeText Menu's have no options just one title and url
            $ussd->title = 'Please provide first and last name';
            $ussd->option_url = 'index.php?file=names';
            return $ussd->addMenu($url);
        break;
        case 3:
            $ussd->title = 'Select your favourite TV show';
            $ussd->options = ['The Simpsons', 'Star Wars', 'Peanuts', 'South Park',
            'Courage the Cowardly Dog', 'Avatar: The Last Airbender',
            'Dexters Laboratory', 'Futurama', 'The Jetsons', 'Phineas and Ferb',
            'Kim Possible', 'Samurai Jack', 'Dora the Explorer'];
            // Menu options can all share the same url
            $ussd->option_url = 'index.php?page=shows';
            // [5] is the amount of options that will be shown per menu
            return $ussd->paginateMenu($url, 5);
        break;
        case 'exit': 
            $ussd->title = "Thank you!\nUssd Platform";
            return $ussd->addMenu($url);
        break;
    }
}

echo initMenu($ussd, $url);
```

## Author

* Azanda Zama 
Email: judah.zama@gmail.com
IG: [@azanda.zama](https://instagram.com/azanda.zama)
Twitter: [@wlrdofazanda](https://twitter.com/wlrdofazanda)
Linkedin: [Azanda Zama](https://za.linkedin.com/in/azanda-zama-a176b2167)


## License

[MIT](https://choosealicense.com/licenses/mit/)
