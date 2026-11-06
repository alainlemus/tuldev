<?php

namespace Database\Seeders;

use App\Enums\AppStatus;
use App\Enums\ServiceIcon;
use App\Models\App;
use App\Models\Faq;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Stat;
use App\Models\Service;
use App\Models\Technology;
use App\Support\ImageOptimizer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LandingContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->services();
        $this->projects();
        $this->apps();
        $this->technologies();
        $this->processSteps();
        $this->faqs();
        $this->stats();
    }

    private function services(): void
    {
        $services = [
            ['ventas/pos', ServiceIcon::Pos, 'Sistemas POS', 'Punto de venta para tu tienda, restaurante o farmacia en Tulancingo o Pachuca: ventas, inventario, cortes de caja y reportes en un solo sistema.'],
            ['apps/movil', ServiceIcon::Movil, 'Apps móviles', 'Aplicaciones iOS y Android para tus clientes o tu equipo: pedidos, citas, tarjetas de lealtad, expedientes y trabajo en campo.'],
            ['tienda/online', ServiceIcon::Tienda, 'Tiendas en línea', 'Tiendas en línea para negocios de Tulancingo y Pachuca: vende las 24 horas con catálogo, carrito, pagos con tarjeta y envíos, conectada a tu inventario real.'],
            ['web/sitios', ServiceIcon::Web, 'Páginas web administrables', 'Páginas web en Tulancingo y Pachuca, rápidas y bien posicionadas en Google, con panel para que actualices tu menú, productos o promociones sin depender de nadie.'],
            ['datos/sql', ServiceIcon::Datos, 'Bases de datos', 'Diseño, migración y optimización de bases de datos: tu información ordenada, respaldada y lista para consultar.'],
            ['sat/cfdi', ServiceIcon::Factura, 'Facturación y timbrado en línea', 'Emite facturas electrónicas (CFDI) con timbrado en línea desde tu sistema o tu tienda: tus clientes facturan al instante y tú te olvidas de capturar a mano.'],
            ['pagos/online', ServiceIcon::Pagos, 'Pagos en línea', 'Cobra con tarjeta, transferencia o efectivo en tu sitio, tienda o app, con la confirmación del pago conectada directo a tu sistema.'],
            ['api/integraciones', ServiceIcon::Codigo, 'Sistemas a la medida e integraciones', 'Paneles administrativos, CRMs y conexiones con pagos, facturación, WhatsApp y Wallet para que todo hable entre sí.'],
        ];

        foreach ($services as $i => [$tag, $icon, $title, $description]) {
            Service::updateOrCreate(['title' => $title], [
                'tag' => $tag,
                'icon' => $icon,
                'description' => $description,
                'sort' => $i + 1,
                'is_active' => true,
            ]);
        }
    }

    private function projects(): void
    {
        // [archivo, nombre, descripción, etiquetas, insignia, duración, retraso, alt]
        $projects = [
            ['fideli', 'Fideli', 'Plataforma de lealtad: tarjetas de puntos en Apple y Google Wallet, campañas por WhatsApp y menú digital con pedidos pagados con tarjeta.', ['SaaS', 'App iOS', 'Pagos en línea'], 'Producto propio', 20, 0, null],
            ['farmacias', 'far+macias', 'Cadena de farmacias: tienda en línea con catálogo y carrito, buscador de sucursales con mapa, monedero electrónico y app móvil.', ['Tienda en línea', 'App', 'Mapas'], null, 22, -4, 'Recorrido por la tienda en línea de far+macias'],
            ['consultoria', 'Consultoría Inmobiliaria', 'Asesoría en créditos INFONAVIT y FOVISSSTE: sitio con servicios, propiedades y blog, más una app para asesores y clientes.', ['Sitio web', 'Blog', 'App iOS y Android'], null, 21, -9, null],
            ['starpubs', 'Star Pubs', 'Restaurante y bar deportivo: agenda de eventos con filtros, menú, galería y reservaciones de mesa.', ['Sitio web', 'Eventos', 'Reservas'], null, 17, -2, null],
            ['panybrasas', 'Pan y Brasas', 'Panadería artesanal: catálogo de productos y encargos en línea, con una identidad cálida que huele a horno de leña.', ['Sitio web', 'Catálogo', 'Encargos'], null, 18, -7, null],
            ['pelana', 'Pelaná', 'Cocina yucateca de barrio: menú administrable, promociones de fin de semana y pedidos directos por WhatsApp.', ['Sitio web', 'Menú', 'WhatsApp'], null, 16, -11, null],
            ['vrstudio', 'VR Studio Arquitectura', 'Despacho de arquitectura: servicios, obras realizadas y proceso de trabajo, del render a la obra terminada.', ['Sitio web', 'Portafolio de obras'], null, 20, -5, null],
            ['litesa', 'Grupo Litesa', 'Importadora y distribuidora: catálogo de iluminación LED, servicios de importación y blog, con modo claro y oscuro.', ['Sitio web', 'Catálogo', 'Blog'], null, 19, -13, null],
            ['mundofit', 'Mundo Fit', 'Gimnasio con 4 sucursales en Tulancingo: planes, sucursales y nutrición, con inscripción directa por WhatsApp.', ['Sitio web', 'Sucursales', 'Planes'], 'En desarrollo', 14, -3, null],
            ['bolivar', 'Funeraria García de Bolívar', 'Funeraria con más de 50 años de experiencia: servicios, panteones, obituario, testimonios y una guía para atravesar el duelo, con atención las 24 horas.', ['Sitio web', 'Obituario', 'Guía del duelo'], null, 21, -6, null],
            ['aguaysal', 'Agua y Sal', 'Tostadería de aguachiles y mariscos en Tulancingo: especialidades, menú por categorías con precios y reservación por WhatsApp.', ['Sitio web', 'Menú', 'Reservas'], null, 19, -10, null],
            ['donpapi', 'Asados Don Papi', 'Asados ahumados estilo americano: carta con precios, horarios de día y de noche, taquería, carnitas un sábado al mes, promociones y reservación por WhatsApp.', ['Sitio web', 'Carta', 'Reservas'], null, 17, -4, null],
            ['novadent', 'NovaDent', 'Laboratorio dental en Tulancingo: prótesis fijas y removibles y protectores bucales a la medida, con proceso en cuatro pasos y cotización por WhatsApp.', ['Sitio web', 'Servicios', 'WhatsApp'], 'En desarrollo', 18, -8, null],
            ['closet', 'Closet Jaltepec', 'Tienda en línea de ropa, calzado y fragancias de marca a precio de outlet en Tulancingo: catálogo por categorías, carrito y pagos con Mercado Pago.', ['Tienda en línea', 'Catálogo', 'Pagos en línea'], null, 19, -6, 'Recorrido por la tienda en línea Closet Jaltepec'],
        ];

        foreach ($projects as $i => [$file, $name, $description, $tags, $badge, $duration, $delay, $alt]) {
            Project::updateOrCreate(['slug' => Str::slug($name)], [
                'name' => $name,
                'description' => $description,
                'tags' => $tags,
                'badge' => $badge,
                'scroll_image' => $this->copy("portafolio/{$file}-scroll.jpg", "projects/{$file}-scroll.jpg"),
                'scroll_alt' => $alt,
                'scroll_duration' => $duration,
                'scroll_delay' => $delay,
                'sort' => $i + 1,
                'is_published' => true,
            ]);
        }
    }

    private function apps(): void
    {
        $apps = [
            ['fideli', 'Fideli', 'App para el equipo del negocio: escanea la tarjeta del cliente, registra visitas, suma puntos y canjea recompensas en segundos.', AppStatus::Publicada, 'Pantallas de la app Fideli: tarjeta de lealtad en Wallet y registro de visitas del equipo'],
            ['consultoria', 'Consultoría Inmobiliaria', 'Una app, dos perfiles: los asesores gestionan expedientes, escanean INE con OCR y trabajan sin conexión; los clientes siguen su trámite y suben documentos.', AppStatus::Publicada, 'Pantallas de la app de Consultoría Inmobiliaria: acceso para asesores y para acreditados'],
            ['farmacias', 'far+macias', 'La farmacia en el teléfono: receta con foto, pedidos con seguimiento, citas médicas, tarjeta de puntos con QR y facturación.', AppStatus::Proximamente, 'Pantallas de la app de far+macias: tienda y tarjeta de puntos con saldo'],
        ];

        foreach ($apps as $i => [$file, $name, $description, $status, $alt]) {
            App::updateOrCreate(['name' => $name], [
                'description' => $description,
                'image' => $this->copy("apps/{$file}.jpg", "apps/{$file}.jpg"),
                'image_alt' => $alt,
                'status' => $status,
                'sort' => $i + 1,
                'is_published' => true,
            ]);
        }
    }

    private function technologies(): void
    {
        // [nombre, logo, fila]
        $technologies = [
            ['PHP', 'php', 1], ['Laravel', 'laravel', 1], ['Livewire', 'livewire', 1], ['Filament', 'capas', 1],
            ['Vue', 'vuedotjs', 1], ['React', 'react', 1], ['Angular', 'angular', 1], ['MySQL', 'mysql', 1],
            ['PostgreSQL', 'postgresql', 1], ['MongoDB', 'mongodb', 1], ['Supabase', 'supabase', 1],
            ['JavaScript', 'javascript', 1], ['HTML', 'html5', 1], ['CSS', 'css3', 1], ['Tailwind CSS', 'tailwindcss', 1],
            ['Bootstrap', 'bootstrap', 1], ['Java', 'java', 1], ['Kotlin', 'kotlin', 1], ['Swift', 'swift', 1],
            ['React Native', 'react', 2], ['Expo', 'expo', 2], ['App Store Connect', 'appstore', 2],
            ['Google Play Console', 'googleplay', 2], ['VPS', 'servidor', 2], ['Docker', 'docker', 2],
            ['AWS', 'aws', 2], ['Dokploy', 'cohete', 2], ['Hostinger', 'hostinger', 2], ['CLI', 'terminal', 2], ['GitHub', 'github', 2],
            ['Stripe', 'stripe', 2], ['Facturapi', 'factura', 2], ['Resend', 'resend', 2], ['WhatsApp', 'whatsapp', 2],
            ['Apple Wallet', 'apple', 2], ['Google Wallet', 'wallet', 2],
        ];

        foreach ($technologies as $i => [$name, $logo, $row]) {
            Technology::updateOrCreate(['name' => $name], [
                'logo' => $this->copy("logos/{$logo}.svg", "technologies/{$logo}.svg"),
                'row' => $row,
                'sort' => $i + 1,
                'is_active' => true,
            ]);
        }
    }

    private function processSteps(): void
    {
        $steps = [
            ['Escuchamos', 'Platicamos contigo para entender cómo opera tu negocio, qué te quita tiempo y qué quieres lograr.'],
            ['Diseñamos', 'Definimos los procesos y diseñamos la base de datos y las pantallas antes de escribir código.'],
            ['Programamos', 'Construimos tu sistema desde cero, ya sea POS, app, tienda o sitio, y lo revisamos contigo mientras avanza.'],
            ['Entregamos', 'Lo ponemos en marcha en tu negocio, lo conectamos a tus herramientas y te mostramos cómo usarlo.'],
        ];

        foreach ($steps as $i => [$title, $description]) {
            ProcessStep::updateOrCreate(['title' => $title], ['description' => $description, 'sort' => $i + 1, 'is_active' => true]);
        }
    }

    private function faqs(): void
    {
        $faqs = [
            ['¿Usan plantillas?', 'No. Cada sistema se diseña y se programa desde cero alrededor de cómo opera tu negocio.'],
            ['¿Qué tipo de proyectos desarrollan?', 'Sistemas POS, apps móviles para iOS y Android, tiendas en línea, sitios web administrables, bases de datos y sistemas a la medida con integraciones de pagos, facturación, WhatsApp y Wallet.'],
            ['¿Solo trabajan en Tulancingo?', 'Estamos en Tulancingo, Hidalgo, y desarrollamos proyectos para negocios de todo México.'],
            ['¿Cómo empiezo?', 'Déjanos tus datos en el formulario o escríbenos por WhatsApp. Te contactamos para entender cómo trabajas y proponerte una solución, sin compromiso.'],
            ['¿Puedo actualizar yo mismo el contenido de mi sitio?', 'Sí. Los sitios incluyen un panel para que actualices tu menú, tus productos o tus promociones sin depender de nadie.'],
            ['¿Qué servicios de desarrollo de software ofrecen en Tulancingo?', 'Desarrollamos páginas web, tiendas en línea, sistemas POS, apps móviles, bases de datos, facturación y timbrado en línea, pagos en línea y sistemas a la medida para negocios de Tulancingo y la región.'],
            ['¿También desarrollan software para negocios de Pachuca?', 'Sí. Estamos en Tulancingo y desarrollamos páginas web, tiendas en línea, sistemas POS, apps móviles, bases de datos, facturación y timbrado en línea, pagos en línea y sistemas a la medida para negocios de Pachuca y todo Hidalgo.'],
        ];

        foreach ($faqs as $i => [$question, $answer]) {
            Faq::updateOrCreate(['question' => $question], ['answer' => $answer, 'sort' => $i + 1, 'is_published' => true]);
        }
    }

    /** Cifras verificables con el contenido actual; edítalas desde el panel cuando cambien. */
    private function stats(): void
    {
        $stats = [
            ['15+', 'años de experiencia'],
            [(string) Project::count(), 'proyectos en nuestro portafolio'],
            ['2', 'apps publicadas en tiendas'],
        ];

        foreach ($stats as $i => [$value, $label]) {
            Stat::updateOrCreate(['label' => $label], ['value' => $value, 'sort' => $i + 1, 'is_published' => true]);
        }
    }

    /** Copia un archivo de design/assets al disco público y devuelve su ruta relativa. */
    private function copy(string $from, string $to): string
    {
        $source = base_path("design/assets/{$from}");

        if (! File::exists($source)) {
            throw new \RuntimeException("No existe el recurso de diseño: {$source}");
        }

        Storage::disk('public')->put($to, File::get($source));

        return ImageOptimizer::convert($to);
    }
}
