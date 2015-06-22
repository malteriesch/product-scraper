Scraper
============
A simple Console Application to scrape data from a listing on a web page

Installation
-------------------
* note that this is tested on Linux only.
* make sure that you have composer installed.
* in root of project, run composer install


Running the application
-----------------------------
from root folder, run
`php app/scrape.php scrape:url  "http://www.sainsburys.co.uk/shop/gb/groceries/fruit-veg/new-in-season#langId=44&storeId=10151&catalogId=10122&categoryId=12524&parent_category_rn=12518&top_category=12518&pageSize=30&orderBy=FAVOURITES_FIRST&searchTerm=&beginIndex=0" > out.json`

Note that this application is designed for Linux as it supports pipes

Tests
--------------
To run tests, go to the tests folder and run `phpunit`