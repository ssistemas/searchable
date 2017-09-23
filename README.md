# Searchable for Laravel 5.*
a simple trait to use with your Laravel Models

## Usage

### Step 1: Install Through Composer

```
 composer require ssistemas/searchable:"1.*"
```


### Step 2: Install Trait model

just add in your models
```php
    class User extends Model
    {
        use Ssistemas\Searchable\Traits\Searchable;
        private $searchable = [
            'columns'=>['category.name'],
            'joins'=>[
                'customers' => ['category.id','user.category_id'],
            ],
        'orders'=>['category.name,asc'],
        ];
        ...
    }
```
### Step 2: Use Controller

you can also use controller
```php
    $users = User::search($value)->get();
```
