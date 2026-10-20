<x-mail::message>
# Nueva solicitud de contacto

Recibiste un mensaje desde la landing de Codemida.

<x-mail::table>
| Dato | Detalle |
| :--- | :------ |
| Nombre | {{ $lead->name }} |
| Negocio | {{ $lead->business ?: '—' }} |
| WhatsApp | {{ $lead->whatsapp }} |
| Correo | {{ $lead->email ?: '—' }} |
| Necesita | {{ $lead->type->getLabel() }} |
</x-mail::table>

@if ($lead->message)
**Mensaje**

{{ $lead->message }}
@endif

<x-mail::button :url="$lead->whatsappUrl()">
Abrir WhatsApp
</x-mail::button>

<x-mail::button :url="route('filament.admin.resources.leads.view', $lead)" color="success">
Ver en el panel
</x-mail::button>

Recibido el {{ $lead->created_at->format('d/m/Y \a \l\a\s H:i') }}.
</x-mail::message>
