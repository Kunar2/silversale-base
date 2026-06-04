SilverSale

SilverSale is an e-commerce web application developed using PHP, PostgreSQL (Supabase), HTML, CSS, and JavaScript.

Requirements
1. PHP 8.x
2. Composer
3. Apache Web Server
4. PostgreSQL / Supabase database

Setup
1. Extract the project files.
2. Create a .env file and configure the required database credentials.
3. Run the following command to install dependencies:
composer install
4. Configure Apache so that the document root points to the public directory of the project.
5. Start Apache and access the application through:
http://silversale.local

Notes
The .env file has been excluded for security reasons.
The vendor directory has been excluded and can be regenerated using composer install.
The project was developed using an Apache virtual host configuration where http://silversale.local points directly to the public directory.