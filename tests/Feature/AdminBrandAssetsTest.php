<?php

it('arma el favicon y los logotipos del panel con la petición, no al registrar el panel', function () {
    // Un host distinto de APP_URL y detrás del proxy: si la URL se generó antes de la petición, no saldría así.
    $this->withHeaders(['X-Forwarded-Proto' => 'https'])
        ->get('http://panel.example.test/admin/login')
        ->assertOk()
        ->assertSee('<link rel="icon" href="https://panel.example.test/favicon.svg"', false)
        ->assertSee('src="https://panel.example.test/brand/svg/nombre-solo-para-fondo-claro.svg"', false)
        ->assertSee('src="https://panel.example.test/brand/svg/nombre-solo-para-fondo-oscuro.svg"', false);
});
