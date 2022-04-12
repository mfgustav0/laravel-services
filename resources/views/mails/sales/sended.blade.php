@component('mail::message')
# Olá {{ $client->name }}! Seu pedido {{ $sale->id }} foi Enviado! Em breve seu pedido chegará em sua casa!

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
