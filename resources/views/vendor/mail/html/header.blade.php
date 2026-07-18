@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo-v2.1.png" class="logo" alt="Laravel Logo">
@else
<img src="https://i.postimg.cc/C19sNQPd/download-(6).png" class="logo" alt="{{ $slot }} Logo">
@endif
</a>
</td>
</tr>
