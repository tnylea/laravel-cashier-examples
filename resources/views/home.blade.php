@extends('layouts.app')

@section('content')
    <div class="flex items-center">
        <div class="md:w-1/2 md:mx-auto">

            @if (session('status'))
                <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">

                <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                    Dashboard
                </div>

                <div class="w-full p-6">
                    <p class="text-gray-700">You are logged in!</p>

                    <!-- If user is not subscribed to a plan, show them the payment form -->
                    @if(!auth()->user()->subscribed('main'))

                        @if(session('error_message'))
                            <div role="alert" class="mb-4">
                                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                                    Payment Failed
                                </div>
                                <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                                    <p>{{ session('error_message') }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="w-2/3 rounded border border-gray-200 mx-auto mt-8 p-6 clearfix">
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">You are not a subscribed to a plan</strong>
                                <span class="block mt-2">To become a subscriber enter your billing info below:</span>
                            </div>
                            
                            <form id="signup-form" action="{{ route('billing') }}" method="post">
                                @csrf
                                <div class="flex flex-wrap mb-6 mt-8 px-6">
                                        <label for="card-element" class="block text-gray-700 text-sm font-bold mb-2">
                                            Name on Card
                                        </label>
                                        <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div class="flex flex-wrap mb-6 mt-8 px-6">
                                    <label for="card-element" class="block text-gray-700 text-sm font-bold mb-2">
                                        Credit Card Info
                                    </label>
                                    <!-- Stripe Elements Placeholder -->
                                    <div id="card-element" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></div>
                                    <div id="card-errors" class="text-red-400 text-bold mt-2 text-sm font-medium"></div>
                                </div>
                                
                                <button type="submit" id="card-button" data-secret="{{ $intent->client_secret }}" class="inline-block align-middle text-center select-none border font-bold whitespace-no-wrap py-2 px-4 rounded text-base leading-normal no-underline text-gray-100 bg-blue-500 hover:bg-blue-700 float-right mr-6">
                                    Subscribe
                                </button>
                            </form>
                        </div>

                    <!-- Otherwise if the user is subscribed, show them a success message -->
                    @else
                    
                        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mt-8" role="alert">
                            <p class="font-bold mb-2">Thanks for being a customer!</p>
                            <p>You Are Subscribed to the Starter Plan.</p>
                        </div>

                    @endif
                </div>
            </div>
            
        </div>
    </div>
@endsection

@section('javascript')
    @if(!auth()->user()->subscribed('main'))
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            const stripe = Stripe('{{ env("STRIPE_KEY") }}');

            const elements = stripe.elements();
            const cardElement = elements.create('card');

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;
            const cardError = document.getElementById('card-errors');

            cardElement.addEventListener('change', function(event) {
                if (event.error) {
                    cardError.textContent = event.error.message;
                } else {
                    cardError.textContent = '';
                }
            });

            var form = document.getElementById('signup-form');

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const { setupIntent, error } = await stripe.handleCardSetup(
                    clientSecret, cardElement, {
                        payment_method_data: {
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                );

                if (error) {
                    // Display "error.message" to the user...
                    console.log(error);
                } else {
                    // The card has been verified successfully...
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'payment_method');
                    hiddenInput.setAttribute('value', setupIntent.payment_method);
                    form.appendChild(hiddenInput);
                    // Submit the form
                    form.submit();
                }
            });
        
        </script>
    @endif
@endsection
