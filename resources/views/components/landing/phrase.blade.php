@props(['s'])
@php
    $words = collect(preg_split('/\s+/', trim($s->phrase), -1, PREG_SPLIT_NO_EMPTY))->map(fn ($w) => [$w, 'cm-word'])
        ->merge(collect(preg_split('/\s+/', trim($s->phrase_accent), -1, PREG_SPLIT_NO_EMPTY))->map(fn ($w) => [$w, 'cm-word-a']));
@endphp
@php
    // Fondo decorativo: fragmentos de código que se desplazan con el scroll (solo visual, oculto a lectores de pantalla).
    $codeColumns = [
        [
            '<span class="c">// app/Models/Venta.php</span>',
            '<span class="k">class</span> <span class="f">Venta</span> <span class="k">extends</span> Model',
            '{',
            '    <span class="k">public function</span> <span class="f">total</span>(): <span class="k">float</span>',
            '    {',
            '        <span class="k">return</span> $this-&gt;items-&gt;<span class="f">sum</span>(<span class="k">fn</span> ($i) =&gt; $i-&gt;precio * $i-&gt;cantidad);',
            '    }',
            '',
            '    <span class="k">public function</span> <span class="f">cerrarCaja</span>(): <span class="k">void</span>',
            '    {',
            '        $this-&gt;update([<span class="s">&#39;estado&#39;</span> =&gt; <span class="s">&#39;cerrada&#39;</span>]);',
            '        <span class="f">event</span>(<span class="k">new</span> CorteGenerado($this));',
            '    }',
            '}',
            '',
            '<span class="c">// routes/api.php</span>',
            'Route::<span class="f">post</span>(<span class="s">&#39;/pedidos&#39;</span>, [PedidoController::<span class="k">class</span>, <span class="s">&#39;store&#39;</span>]);',
            'Route::<span class="f">get</span>(<span class="s">&#39;/inventario&#39;</span>, InventarioController::<span class="k">class</span>);',
            '',
        ],
        [
            '<span class="k">SELECT</span> p.nombre, <span class="f">SUM</span>(d.cantidad) <span class="k">AS</span> vendidos',
            '<span class="k">FROM</span> productos p',
            '<span class="k">JOIN</span> detalle_ventas d <span class="k">ON</span> d.producto_id = p.id',
            '<span class="k">WHERE</span> d.created_at &gt;= <span class="f">NOW</span>() - <span class="k">INTERVAL</span> 30 <span class="k">DAY</span>',
            '<span class="k">GROUP BY</span> p.id',
            '<span class="k">ORDER BY</span> vendidos <span class="k">DESC</span>;',
            '',
            '<span class="k">Schema</span>::<span class="f">create</span>(<span class="s">&#39;clientes&#39;</span>, <span class="k">function</span> ($t) {',
            '    $t-&gt;<span class="f">id</span>();',
            '    $t-&gt;<span class="f">string</span>(<span class="s">&#39;nombre&#39;</span>);',
            '    $t-&gt;<span class="f">string</span>(<span class="s">&#39;whatsapp&#39;</span>, 20)-&gt;<span class="f">index</span>();',
            '    $t-&gt;<span class="f">timestamps</span>();',
            '});',
            '',
            '<span class="c">// Livewire</span>',
            '<span class="k">public function</span> <span class="f">guardar</span>()',
            '{',
            '    $this-&gt;<span class="f">validate</span>();',
            '    Lead::<span class="f">create</span>($this-&gt;<span class="f">only</span>(<span class="s">&#39;name&#39;</span>, <span class="s">&#39;whatsapp&#39;</span>));',
            '}',
            '',
        ],
        [
            '<span class="k">const</span> <span class="f">pedido</span> = <span class="k">await</span> api.<span class="f">post</span>(<span class="s">&#39;/pedidos&#39;</span>, {',
            '    cliente: usuario.id,',
            '    productos: carrito.<span class="f">map</span>(p =&gt; p.id),',
            '});',
            '',
            '<span class="k">export default function</span> <span class="f">Tarjeta</span>({ puntos }) {',
            '    <span class="k">return</span> (',
            '        &lt;<span class="f">Wallet</span> saldo={puntos} /&gt;',
            '    );',
            '}',
            '',
            '<span class="c"># docker-compose.yml</span>',
            'services:',
            '  app:',
            '    image: codemida/app:latest',
            '    restart: always',
            '    depends_on: [db, redis]',
            '',
            '<span class="f">$</span> php artisan migrate --force',
            '<span class="f">$</span> npm run build',
            '<span class="s">✓</span> listo para vender',
            '',
        ],
    ];
@endphp
  <section aria-label="Nuestra forma de trabajar" class="cm-pin">
   <div class="cm-pin-stick">
    <div class="cm-code" aria-hidden="true">
      @foreach ($codeColumns as $i => $lines)
      <pre class="cm-code-col" style="--spd: {{ [380, 620, 480][$i] }}; --dir: {{ $i === 1 ? -1 : 1 }}"><code>@foreach (range(1, 4) as $repeat)@foreach ($lines as $line){!! $line !!}
@endforeach @endforeach</code></pre>
      @endforeach
    </div>
    <div style="position: relative; z-index: 1; width: 100%; max-width: 1100px; margin: 0 auto; box-sizing: border-box; padding: 140px 24px 60px">
    <p style="margin: 0; font-size: clamp(30px, 4.6vw, 60px); font-weight: 800; letter-spacing: -0.035em; line-height: 1.12; text-wrap: balance">@foreach ($words as [$word, $class])<span class="{{ $class }}">{{ $word }}</span>{{ $loop->last ? '' : ' ' }}@endforeach</p>
    </div>
   </div>
  </section>
