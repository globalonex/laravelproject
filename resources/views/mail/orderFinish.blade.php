<h1>Здравствуйте</h1>
<br>
Вы оформили заказ:
<br>
<table>
@foreach ($orderProducts as $product)
        <tr>
            <td>{{$product->title}}</td>
            <td>{{$product->price}} руб</td>
            <td>{{$product->quantity}} шт.</td>
            <td>{{$product->price * $product->quantity}} руб.</td>
        </tr>
@endforeach
</table>
<br>
Общая сумма заказа: {{$sum}} руб.