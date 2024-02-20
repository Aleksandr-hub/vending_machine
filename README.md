# vending_machine

php bin/console app:vending-machine list  - Output list of products and show there prices
php bin/console app:vending-machine select --product="Snickers"  - Allow select product and show it's price
php bin/console app:insert_coins_command - Accept coins from customer with following nominal, Validate that coin can be accepted, Give customer his product and return change coin if needed