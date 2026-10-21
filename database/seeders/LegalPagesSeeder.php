<?php

namespace Database\Seeders;

use App\Models\LegalPage;
use Illuminate\Database\Seeder;

/**
 * Textos legales iniciales. Los datos del responsable salen de Ajustes mediante marcadores
 * ({{responsable}}, {{domicilio}}, {{correo_privacidad}}, {{sitio}}, {{fecha}}).
 * Son una base de trabajo: conviene que un abogado los revise antes de publicar el sitio.
 */
class LegalPagesSeeder extends Seeder
{
    public function run(): void
    {
        LegalPage::firstOrCreate(
            ['slug' => LegalPage::PRIVACY],
            [
                'title' => 'Aviso de privacidad',
                'meta_description' => 'Aviso de privacidad de Tuldev: qué datos personales recabamos, para qué los usamos y cómo ejercer tus derechos ARCO.',
                'content' => $this->privacy(),
                'sort' => 1,
                'is_published' => true,
            ],
        );

        LegalPage::firstOrCreate(
            ['slug' => LegalPage::TERMS],
            [
                'title' => 'Términos y condiciones',
                'meta_description' => 'Términos y condiciones de uso del sitio web de Tuldev.',
                'content' => $this->terms(),
                'sort' => 2,
                'is_published' => true,
            ],
        );
    }

    private function privacy(): string
    {
        return <<<'HTML'
<p>En cumplimiento de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares y su normativa aplicable, ponemos a tu disposición el presente Aviso de Privacidad.</p>

<h2>1. Identidad y domicilio del responsable</h2>
<p>El responsable del tratamiento de tus datos personales es <strong>{{responsable}}</strong>, con nombre comercial Tuldev, con domicilio en {{domicilio}}. Sitio web: {{sitio}}. Correo para temas de privacidad: {{correo_privacidad}}.</p>

<h2>2. Datos personales que recabamos</h2>
<p>Cuando llenas el formulario de contacto de este sitio recabamos los siguientes datos:</p>
<ul>
<li>Nombre.</li>
<li>Nombre de tu negocio o empresa (opcional).</li>
<li>Número de WhatsApp.</li>
<li>Correo electrónico (opcional).</li>
<li>Tipo de proyecto que necesitas y el mensaje que nos escribes.</li>
</ul>
<p>De forma automática, al enviar el formulario, también registramos tu dirección IP, el tipo de navegador que utilizas y, si llegaste desde una campaña, los parámetros de origen de la visita (por ejemplo utm_source, utm_medium y utm_campaign).</p>
<p>No recabamos datos personales sensibles. Te pedimos no incluir datos de ese tipo en el campo de mensaje.</p>

<h2>3. Finalidades del tratamiento</h2>
<p>Usamos tus datos personales para las siguientes finalidades, necesarias para atender tu solicitud:</p>
<ul>
<li>Contactarte por WhatsApp, correo electrónico o teléfono para responder tu mensaje.</li>
<li>Entender las necesidades de tu negocio y elaborar una propuesta o cotización.</li>
<li>Dar seguimiento a tu solicitud y llevar un registro interno de los contactos recibidos.</li>
<li>Prevenir el uso indebido del formulario, como el envío automatizado de mensajes no deseados.</li>
</ul>
<p>No utilizamos tus datos para finalidades distintas a las anteriores. Si en el futuro quisiéramos utilizarlos para otros fines, como enviarte información comercial, te lo informaremos y pediremos tu consentimiento.</p>

<h2>4. Transferencias y encargados</h2>
<p>No vendemos ni transferimos tus datos personales a terceros, salvo que una autoridad competente lo requiera conforme a la ley.</p>
<p>Para operar el sitio nos apoyamos en proveedores que tratan datos por nuestra cuenta, como servicios de alojamiento web y de envío de correo electrónico. Estos proveedores solo pueden usar los datos para prestarnos el servicio y es posible que sus servidores se encuentren fuera de México.</p>

<h2>5. Cookies y tecnologías similares</h2>
<p>Este sitio utiliza únicamente cookies técnicas necesarias para su funcionamiento y seguridad, por ejemplo para proteger el formulario de contacto. No utilizamos cookies de publicidad ni de seguimiento de comportamiento. Si esto cambia, actualizaremos este aviso.</p>

<h2>6. Derechos de acceso, rectificación, cancelación y oposición (ARCO)</h2>
<p>Tienes derecho a conocer qué datos personales tenemos de ti y para qué los usamos (acceso), a solicitar su corrección si son inexactos o están incompletos (rectificación), a pedir que los eliminemos cuando consideres que no se requieren para las finalidades señaladas (cancelación) y a oponerte a su uso para fines específicos (oposición).</p>
<p>Para ejercer estos derechos envía una solicitud a <strong>{{correo_privacidad}}</strong> que incluya:</p>
<ul>
<li>Tu nombre y un medio para comunicarte la respuesta.</li>
<li>Los documentos que acrediten tu identidad o, en su caso, la representación legal.</li>
<li>La descripción clara y precisa de los datos sobre los que buscas ejercer tus derechos y el derecho que deseas ejercer.</li>
</ul>
<p>Te responderemos en los plazos que establece la ley.</p>

<h2>7. Revocación del consentimiento y limitación de uso</h2>
<p>Puedes revocar el consentimiento que nos diste para el tratamiento de tus datos, o pedir que limitemos su uso o divulgación, enviando tu solicitud al mismo correo señalado en el punto anterior. Ten en cuenta que, en algunos casos, la revocación puede impedir que sigamos atendiendo tu solicitud.</p>

<h2>8. Cambios a este aviso</h2>
<p>Podemos modificar este aviso para atender cambios legales o en la forma en que operamos. Publicaremos cualquier cambio en esta misma página. Fecha de la última actualización: {{fecha}}.</p>

<h2>9. Autoridad</h2>
<p>Si consideras que tu derecho a la protección de datos personales ha sido vulnerado, puedes acudir ante la autoridad competente en materia de protección de datos personales en posesión de particulares conforme a la ley vigente.</p>
HTML;
    }

    private function terms(): string
    {
        return <<<'HTML'
<p>Al acceder y utilizar el sitio web {{sitio}} (el «Sitio») aceptas estos Términos y Condiciones. Si no estás de acuerdo con ellos, te pedimos no utilizar el Sitio.</p>

<h2>1. Quiénes somos</h2>
<p>El Sitio es operado por <strong>{{responsable}}</strong>, con nombre comercial Tuldev, con domicilio en {{domicilio}}. Puedes contactarnos en {{correo_privacidad}}.</p>

<h2>2. Objeto del sitio</h2>
<p>El Sitio presenta información sobre nuestros servicios de desarrollo de software a la medida, nuestro portafolio y las formas de contactarnos. La información publicada tiene fines informativos.</p>

<h2>3. Uso permitido</h2>
<p>Te comprometes a usar el Sitio de forma lícita y de buena fe. Está prohibido:</p>
<ul>
<li>Intentar vulnerar la seguridad del Sitio o acceder a áreas restringidas, como el panel de administración.</li>
<li>Enviar mensajes automatizados, no solicitados o con información falsa a través del formulario de contacto.</li>
<li>Copiar, reproducir o distribuir el contenido del Sitio para fines comerciales sin nuestra autorización.</li>
</ul>

<h2>4. Cotizaciones y servicios</h2>
<p>Enviar el formulario de contacto o escribirnos por WhatsApp no genera ninguna obligación ni contrato. Cualquier proyecto, precio, alcance, plazo o forma de pago se acuerda por escrito en una propuesta o contrato por separado. Los proyectos que se muestran en el portafolio son ejemplos de trabajos realizados y no constituyen una oferta ni una garantía de resultados.</p>

<h2>5. Propiedad intelectual</h2>
<p>El diseño, los textos, las imágenes y demás elementos del Sitio son propiedad de sus titulares y están protegidos por la legislación aplicable en materia de propiedad intelectual. Los nombres, marcas y logotipos de terceros que aparecen en el portafolio pertenecen a sus respectivos dueños y se muestran únicamente para ilustrar el trabajo realizado.</p>

<h2>6. Enlaces y servicios de terceros</h2>
<p>El Sitio puede contener enlaces a servicios de terceros, como WhatsApp o tiendas de aplicaciones. No controlamos esos servicios ni somos responsables de su contenido o de sus políticas de privacidad.</p>

<h2>7. Limitación de responsabilidad</h2>
<p>Hacemos lo posible para que la información del Sitio sea correcta y esté actualizada, pero no garantizamos que esté libre de errores ni que el Sitio funcione sin interrupciones. En la medida permitida por la ley, no somos responsables por daños derivados del uso del Sitio o de la imposibilidad de usarlo.</p>

<h2>8. Privacidad</h2>
<p>El tratamiento de tus datos personales se rige por nuestro Aviso de Privacidad, disponible en este mismo Sitio.</p>

<h2>9. Modificaciones</h2>
<p>Podemos actualizar estos Términos y Condiciones en cualquier momento. La versión vigente es la publicada en esta página. Fecha de la última actualización: {{fecha}}.</p>

<h2>10. Legislación aplicable y jurisdicción</h2>
<p>Estos Términos y Condiciones se rigen por las leyes de los Estados Unidos Mexicanos. Para cualquier controversia, las partes se someten a los tribunales competentes de Tulancingo de Bravo, Hidalgo, renunciando a cualquier otro fuero que pudiera corresponderles.</p>
HTML;
    }
}
