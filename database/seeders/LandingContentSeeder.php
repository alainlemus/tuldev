<?php

namespace Database\Seeders;

use App\Enums\AppStatus;
use App\Enums\ServiceIcon;
use App\Models\App;
use App\Models\Project;
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
    }

    private function services(): void
    {
        $services = [
            ['ventas/pos', ServiceIcon::Pos, 'Sistemas POS', 'Punto de venta para tu tienda, restaurante o farmacia: ventas, inventario, cortes de caja y reportes en un solo sistema.'],
            ['apps/movil', ServiceIcon::Movil, 'Apps móviles', 'Aplicaciones iOS y Android para tus clientes o tu equipo: pedidos, citas, tarjetas de lealtad, expedientes y trabajo en campo.'],
            ['tienda/online', ServiceIcon::Tienda, 'Tiendas en línea', 'Vende las 24 horas con catálogo, carrito, pagos con tarjeta y envíos, conectada a tu inventario real.'],
            ['web/sitios', ServiceIcon::Web, 'Sitios web administrables', 'Páginas rápidas y bien posicionadas en Google, con panel para que actualices tu menú, productos o promociones sin depender de nadie.'],
            ['datos/sql', ServiceIcon::Datos, 'Bases de datos', 'Diseño, migración y optimización de bases de datos: tu información ordenada, respaldada y lista para consultar.'],
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
            ['PostgreSQL', 'postgresql', 1], ['MongoDB', 'mongodb', 1],
            ['React Native', 'react', 2], ['Expo', 'expo', 2], ['App Store Connect', 'appstore', 2],
            ['Google Play Console', 'googleplay', 2], ['VPS', 'servidor', 2], ['Docker', 'docker', 2],
            ['Dokploy', 'cohete', 2], ['Hostinger', 'hostinger', 2], ['CLI', 'terminal', 2], ['GitHub', 'github', 2],
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

    /** Copia un archivo de design/assets al disco público y devuelve su ruta relativa. */
    private function copy(string $from, string $to): string
    {
        $source = base_path("design/assets/{$from}");

        if (! File::exists($source)) {
            throw new \RuntimeException("No existe el recurso de diseño: {$source}");
        }

        Storage::disk('public')->put($to, File::get($source));
        ImageOptimizer::generate($to);

        return $to;
    }
}
