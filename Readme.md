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

### 4. Create a new Stripe Product

When a user enters their Credit Card Info, they are signing up for your `product` and Stripe needs to know a bit about your product, so we need to create a new product inside of Stripe.

Inside your stripe dashboard, go to **Billing->Products**, and click to Add a `New` product:

![register page image](/public/img/products.png)

For this example, I will give my a product a name of `Laravel Cashier Example`, and click **Create Product**:

Next, we need to create a Pricing Plan for our product. We can add as many Pricing plans to a product as we would like, but in this example we will just add one pricing plan called `starter`, this will be the plan **ID**:

![register page image](/public/img/pricing.png)

Then click on **Add pricing plan**, and we've just created our first pricing plan 🙌


### 5. Run The Database Migrations

```
php artisan migrate
```

### 6. Test it out 🤙 You're now accepting payments 💳

#### Example 1 Test

For **example1** (master), you can visit your app `/register` route and you will see the Credit Card field:

![register page image](/public/img/register.png)

Try signing up with the following credentials to test it out:

```
Credit Card Number: 4242 4242 4242 4242
Expires: 04/24
CVC Code: 242
Zip: 42424
```

Awesome right!

#### Example 2 Test

Make sure to checkout the `example2` branch to "Checkout" this example:




## Payment Up Front on the Register Page (master branch)

You may want to accept payments by requiring payment upon registration (with trial days or without). This functionality is stored in the `master` branch. Here are the steps