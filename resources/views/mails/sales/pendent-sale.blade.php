@component('mail::message')
# Olá {{ $client->name }}! Seu pedido {{ $sale->id }} foi gerado!

@component('mail::table')
	| Produto       | Quantidade     | Valor    |
	| :------------- |:-------------:| --------:|
	@foreach($sale->products as $product)
	| {{ $product->description }} | {{ $product->quantity }} | R$ {{ $product->value }} |
	@endforeach
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
