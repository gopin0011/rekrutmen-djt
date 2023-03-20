@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === "DJT - Human Resources")
<img src="https://rekrutmen.djt-system.com/icon.png" class="logo" alt="DJT Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
