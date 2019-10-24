# Laravel Cashier Examples

The [Laravel Docs](https://laravel.com/docs) are great... But, there are a few things that seemed to be missing in the [Laravel Cashier Documentation](https://laravel.com/docs/billing), such as basic examples of how to submit the payment form in order to capture payment on the other end. Don't get me wrong, the docs are still amazing, but I wanted to create these examples that anyone can download and easily view a working version of [Cashier](https://github.com/laravel/cashier).

This repo contains 2 examples of accepting payments:

1. Accepting Payment Up Front on the Register Page **master** branch
2. Accepting Payment for the currently logged in user **example2** branch.

## Installation

The install instructions are the same for both examples. After installing you can switch between the 2 branches to test each example. These install instructions assume that you are using Laravel Valet or a similar Laravel local server:

### 1. Clone the repo

```
git clone https://github.com/tnylea/laravel-cashier-examples.git
```

### 2. Change directories and install dependencies

```
cd laravel-cashier-examples
composer install
```

### 3. Add your database  & stripe credentials

Next, copy or rename `.env.example` to `.env`. Then you'll need to **create a new database** and add your database credentials to the `.env` file.:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel-cashier-examples
DB_USERNAME=root
DB_PASSWORD=
```

We also want to add our Stripe API keys. Head on over to [Stripe](https://stripe.com/) dashboard, and under the **Developer->API Keys** section you'll find your `Publishable key` and your `Secret key`:

![stripe dashboard image](/public/img/stripe-api-keys-dashboard.png)

Add these keys to the bottom of your .env file:

```
# Test Keys
STRIPE_KEY=pk_test_RKDJpn1L9eRdJOBF3WfaLKRR00VbHCT6ju
STRIPE_SECRET=sk_test_SomeReallyL0ngRand0m5tring...
```

## Payment Up Front on the Register Page (master branch)

You may want to accept payments by requiring payment upon registration (with trial days or without). This functionality is stored in the `master` branch. Here are the steps