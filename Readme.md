# Laravel Cashier Examples

![Laravel Cashier Examples image](/public/img/laravel-cashier-examples.png)

The [Laravel Docs](https://laravel.com/docs) are great... But, there are a few things that seemed to be missing in the [Laravel Cashier Documentation](https://laravel.com/docs/billing), such as basic examples of how to submit the payment form in order to capture payment on the other end. Don't get me wrong, the docs are still amazing, but I wanted to create these examples that anyone can download and easily view a working version of [Cashier](https://github.com/laravel/cashier).

This repo contains 2 examples of accepting payments:

1. Accepting Payment Up Front on the Register Page **master** and **example3** branch
2. Accepting Payment for the currently logged in user **example2** and **example4** branch.

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

![products page image](/public/img/products.png)

For this example, I will give my a product a name of `Laravel Cashier Example`, and click **Create Product**:

![stripe plan image](/public/img/product.png)

Next, we need to create a Pricing Plan for our product. We can add as many Pricing plans to a product as we would like, but in this example we will just add one pricing plan called `starter`, this will be the plan **ID**:

![pricing page image](/public/img/pricing.png)

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

And after signing up, you will be redirected to your application dashboard:

![dashboard image](/public/img/dashboard.png)

There will now be a new user in your database. You will also see a new entry in the `subscriptions` table:

![database image](/public/img/subscription.png)

Additionally, if you login to your stripe dashboard you will see that you now have a new customer.

![stripe purchase image](/public/img/dashboard-home.png)

🔮 Magic!

#### Example 2 Test

Make sure to checkout the `example2` branch to "Checkout" this example:

In example2 the user can register for an account without adding a credit card at signup. Register for an account and you will see a Credit Card Input on the dashboard:

![example 2 dashboard image](/public/img/example2-dashboard.png)

You'll see that on the dashboard there is also a message stating that you are not subscribed to any plan. 

Try entering the following Credit Card info and subscribing:

```
Credit Card Number: 4242 4242 4242 4242
Expires: 04/24
CVC Code: 242
Zip: 42424
```

Upon entering the credit card info and clicking the **Subscribe** button, you will be redirected back to the dashboard showing a message that you are a subscribed customer 🤟

![dashboard subscribed image](/public/img/subscribed.png)

You will also see a new entry in the `subscriptions` table of your application, and you'll see a new customer in your Stripe Dashboard.

👻 Scary Awesome!

#### Example 3 & Example 4

Example 3 is similar to the master branch
Example 4 is similar to example 3.

The difference between example 3 and 4 is that they are able to support [SCA] (https://laravel.com/docs/6.x/billing#strong-customer-authentication).

Master and Example 2 are leveraging the following JS method:

[stripe.createPaymentMethod](https://stripe.com/docs/stripe-js/reference#stripe-create-payment-method)

Whereas Example 3 and 4 are leveraging the following JS method:

[stripe.handleCardSetup](https://stripe.com/docs/stripe-js/reference#stripe-handle-card-setup)
These will handle any kind of SCA or Dynamic 3D Secure functionality. It might be ideal to stick with either Example3 or 4. If you use master or example 2, you'll want to manually redirect the user to the SCA page after they have purchased: [Payments Requiring Additional Confirmation](https://laravel.com/docs/6.x/billing#payments-requiring-additional-confirmation)