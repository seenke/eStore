@component('mail::message')
# Dobrodosli na eStore

Vasa koda za potrditev uporabniskega racuna je : {{$code}}
<br>Hvala za zaupanje</br>

{{ config('app.name') }}
@endcomponent
