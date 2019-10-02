<div class="card-header">
    <div class="level">
        <span class="flex">
            {{ $header }}
        </span>
    </div>
</div>
@if(isset($body))
<div class="card-body">
    {{ $body }}
</div>
@endif
