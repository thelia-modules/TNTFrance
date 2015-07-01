# TNT Express National 

Delivery module for [TNT Express National](http://www.tnt.fr)

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is TNTFrance.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/tnt-france-module:~1.0
```

## Configuration Test
 - Do you want to activate TNT Express National : YES
 - Use the production mode ? : NO
 - TNT Account Number : 06324676
 - TNT Username : webservices@tnt.fr
 - TNT password : test
 - Use individual : YES (default one if no services are choosen)
 - Use enterprise : YES
 - Use TNT depot : YES
 - Use drop off point  : YES
 - List of available products : CHECK ALL TO YES
 - List of available options : CHECK ALL TO YES
 - Regular pickup : NO
 - Print format, options : Choose your stickers format you want from TNT
 - Use free shipping : NO
 - Max weight per package (kg) : 25