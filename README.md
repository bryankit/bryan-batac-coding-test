<a name="readme-top"></a>

<div align="center">
    <h3 align="center">Backend Developer coding test</h3>
</div>


## How to Setup

* Clone the repository in https://github.com/bryankit/bryan-batac-coding-test
* After Cloning run "composer install".
* Duplicate `.env.example` and name it as `.env`.
* Run `php artisan key:generate` to Generate app key:.
* Create database in MySQL namely `laravel` and `unittesting`.
* Run `php artisan migrate:fresh --seed` to migrate and seed
* Run `php artisan serve`.

## Notes
* I have created a postman collection for this that is located in the root directory namely `ITW.postman_collection`.
* I added a bearer token for auth = `1|At3zEaX1oZsZdlzWHdd8rEX143cDclJBQrGVTHLo`
* Run `php artisan test --testsuite=Feature --env=testing` for feature testing.

#### Answer the question below by updating this file.

Q: The management requested a new feature where in the fictional e-commerce app must have a "featured products" section.
How would you go about implementing this feature in the backend?

A: i will add a column in products table namely "featured" then i will set the type to boolean to check if it is featured or not. Then i will add an API route Update for featured products.
