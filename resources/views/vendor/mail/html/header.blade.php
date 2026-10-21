@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Tuldev')
<img src="{{ asset('brand/png/logotipo-horizontal-para-fondo-claro-chico.png') }}" width="160" class="logo" alt="Tuldev" style="width: 160px; height: auto; max-height: none;">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
