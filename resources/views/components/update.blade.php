<p class="text-muted">
    {{ empty(trim($slot)) ? 'Added' : $slot}} {{\Carbon\Carbon::parse($date)->diffForHumans()}} minutes ago
    @if(isset($name))
        by {{$name}}
    @endif
</p>
