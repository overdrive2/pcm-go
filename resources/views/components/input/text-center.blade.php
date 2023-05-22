<div class="table">
    <div style=
      "#position: absolute; #top: 50%;display: table-cell; vertical-align: middle;">
      <div {{ $attributes->merge(['class' => 'px-2 rounded-md']) }}>
        {{ $slot }}
      </div>
    </div>
</div>
