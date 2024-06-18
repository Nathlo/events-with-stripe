<x-app-layout>  

    <div class="container mx-auto mt-5">
        <form action="{{ route('event.store') }}" method="post" id="form">
            @csrf
    
            <x-input-label for="title" value='Titre' />
            <x-text-input id="title" name="title" type="text" :value="old('title')" />
            
            <x-input-label for="content" value='Contenu' />
            <textarea id="content" name="content" :value="old('content')" ></textarea>
    
            <x-input-label for="premium" value='Premium' />
            <x-text-input id="premium" name="premium" type="checkbox" :value="old('premium')" />
            {{-- inputs for the DATE --}}
            <x-input-label for="starts_at" value='Date de démarrage' />
            <x-text-input id="starts_at" name="starts_at" type="date" :value="old('starts_at')" />

            <x-input-label for="ends_at" value='Date de fin' />
            <x-text-input id="ends_at" name="ends_at" type="date" :value="old('ends_at')" />
            {{-- inputs for the TIME --}}
            <x-input-label for="starts_at" value='Heure de démarrage' />
            <x-text-input id="starts_at" name="starts_at" type="time" :value="old('starts_at')" />

            <x-input-label for="ends_at" value='Heure de fin' />
            <x-text-input id="ends_at" name="ends_at" type="time" :value="old('ends_at')" />

            <x-input-label for="tags" value="Les tags (séparés par une virgule)" />
            <x-text-input id="tags" name="tags" type="text" :value="old('tags')" />

            <x-text-input id="payment_method" name="payment_method" type="hidden" />

            <div id="card-element"></div>

            <div class="block mt-3">
                <x-primary-button type="submit" id="submit-button">Créer mon événement</x-primary-button>
            </div>

        </form>
    </div>
    @section('extra-js')
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            const stripe = Stripe(" {{ env('STRIPE_KEY') }} ");

            const elements = stripe.elements();
            const cardElement = elements.create('card', {
                classes: {
                    base: 'StripeElement bg-white w-1/2 p-2 my-2 rounded-lg'
                }
            });

            cardElement.mount('#card-element');

            const cardButton = document.getElementById('submit-button');
            cardButton.addEventListener('click', async(e) => {
                e.preventDefault();

                const { paymentMethod, error } = await stripe.createPaymentMethod('card', cardElement);

                if (error) {
                    alert(error)
                } else {
                    document.getElementById('payment_method').value = paymentMethod.id;
                }

                document.getElementById('form').submit();
            });


        </script>
    @endsection
   
</x-app-layout>