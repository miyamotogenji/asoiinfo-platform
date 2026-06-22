<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ComingSoonController extends Controller
{
    private function phases(): array
    {
        return [
            'billing' => [
                'label'       => 'Phase 2',
                'title'       => 'Facturación & Cuentas por Cobrar',
                'description' => 'Generación de facturas PDF, cobro automático mensual, gestión de cuentas por cobrar (CxC) y notificaciones de pago. Esta fase estará lista en las próximas semanas.',
                'period'      => 'Semanas 3–6',
                'bg'          => '#0EA5E9',
                'color'       => '#38BDF8',
                'features' => [
                    'Generación automática de facturas PDF',
                    'Cobro recurrente mensual (scheduler)',
                    'Registro y aprobación de pagos',
                    'Webhook de pasarela de pagos (Stripe/PayPhone)',
                    'Alertas de vencimiento y bloqueo automático',
                    'Envío de facturas por email',
                ],
                'requires' => [
                    'API key de pasarela de pagos (Stripe / PayPhone)',
                    'Configuración SMTP para envío de emails',
                    'Servidor de producción con PostgreSQL',
                ],
            ],
            'whatsapp' => [
                'label'       => 'Phase 3',
                'title'       => 'WhatsApp Omnicanal',
                'description' => 'Integración en vivo con Meta WhatsApp Business API. Bandeja dual (Soporte + Ventas), actualización en tiempo real y tickets automáticos.',
                'period'      => 'Semanas 7–10',
                'bg'          => '#25D366',
                'color'       => '#34D399',
                'icon'        => '<svg class="w-12 h-12" fill="currentColor" style="color:#25D366" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>',
                'features' => [
                    'Conexión en vivo con Meta WhatsApp Business API',
                    'Bandeja dual: Soporte + Ventas',
                    'Mensajes en tiempo real (sin recargar página)',
                    'Creación automática de tickets (después de N mensajes)',
                    'Atender, transferir y cerrar conversaciones',
                    'Enviar facturas y alertas por WhatsApp',
                    'Plantillas de mensajes pre-aprobadas por Meta',
                ],
                'requires' => [
                    'Meta Business WhatsApp Phone Number ID',
                    'Token de acceso permanente de Meta',
                    'Plantillas de mensajes aprobadas por Meta',
                ],
            ],
            'ai' => [
                'label'       => 'Phase 4',
                'title'       => 'Inteligencia Artificial & Integraciones',
                'description' => 'Respuestas sugeridas por IA, análisis de sentimiento, facturación electrónica SRI Ecuador e integración con Spartha POS.',
                'period'      => 'Semanas 11–18',
                'bg'          => '#F59E0B',
                'color'       => '#FCD34D',
                'features' => [
                    'Respuestas sugeridas por IA (OpenAI / Gemini)',
                    'Análisis de sentimiento y detección de escalada',
                    'Facturación electrónica SRI Ecuador (certificado digital)',
                    'Integración con Spartha POS (búsqueda de clientes)',
                    'Planes de pago / acuerdos de pago en cuotas',
                    'Analíticas avanzadas y exportación de reportes',
                    'Panel de gestión de usuarios y configuración',
                ],
                'requires' => [
                    'Certificado digital SRI (.p12) + contraseña',
                    'Credenciales API de Spartha POS',
                    'API key OpenAI o Gemini (para respuestas IA)',
                    'Credenciales AWS S3 (para almacenamiento de archivos)',
                ],
            ],
        ];
    }

    public function billing()
    {
        return view('admin.coming-soon', ['phase' => $this->phases()['billing']]);
    }

    public function whatsapp()
    {
        return view('admin.coming-soon', ['phase' => $this->phases()['whatsapp']]);
    }

    public function ai()
    {
        return view('admin.coming-soon', ['phase' => $this->phases()['ai']]);
    }

    public function downloadMilestone(): BinaryFileResponse
    {
        $file = public_path('ASOIINFO-Milestone-Plan-2026.xlsx');
        return response()->download($file, 'ASOIINFO-Milestone-Plan-2026.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
