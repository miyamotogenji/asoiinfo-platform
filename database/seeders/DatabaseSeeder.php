<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\BusinessGroup;
use App\Models\LegalEntity;
use App\Models\Branch;
use App\Models\Contact;
use App\Models\Plan;
use App\Models\ContractedService;
use App\Models\WhatsappNumber;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Roles ----
        $roles = ['superadmin', 'admin', 'accounting', 'support_agent', 'sales', 'technician'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // ---- Default admin user ----
        $admin = User::firstOrCreate(
            ['email' => 'admin@asoiinfo.com'],
            ['name' => 'Administrador ASOIINFO', 'password' => Hash::make('Admin2026!')]
        );
        $admin->assignRole('superadmin');

        $agent = User::firstOrCreate(
            ['email' => 'asesor@asoiinfo.com'],
            ['name' => 'María Asesor', 'password' => Hash::make('Agent2026!')]
        );
        $agent->assignRole('support_agent');

        $accounting = User::firstOrCreate(
            ['email' => 'contabilidad@asoiinfo.com'],
            ['name' => 'Carlos Contabilidad', 'password' => Hash::make('Conta2026!')]
        );
        $accounting->assignRole('accounting');

        // ---- Plans ----
        $planPosMonthly = Plan::firstOrCreate(['code' => 'SPARTHA-POS-M'], [
            'name'              => 'Spartha POS mensual',
            'type'              => 'recurring',
            'period'            => 'monthly',
            'price_without_iva' => 21.74,
            'iva_rate'          => 15.00,
            'auto_block'        => true,
            'grace_days'        => 5,
            'billing_day_suggestion' => 1,
            'status'            => 'active',
            'description'       => 'Sistema Spartha POS — pago mensual',
        ]);

        $planPosAnnual = Plan::firstOrCreate(['code' => 'SPARTHA-POS-A'], [
            'name'              => 'Spartha POS anual',
            'type'              => 'recurring',
            'period'            => 'annual',
            'price_without_iva' => 173.91,
            'iva_rate'          => 15.00,
            'auto_block'        => true,
            'grace_days'        => 15,
            'billing_day_suggestion' => 1,
            'status'            => 'active',
            'description'       => 'Sistema Spartha POS — pago anual',
        ]);

        $planWebBasic = Plan::firstOrCreate(['code' => 'WEB-BASIC-M'], [
            'name'              => 'Sistema web básico mensual',
            'type'              => 'recurring',
            'period'            => 'monthly',
            'price_without_iva' => 4.35,
            'iva_rate'          => 15.00,
            'auto_block'        => false,
            'grace_days'        => 5,
            'status'            => 'active',
        ]);

        $planFactElect = Plan::firstOrCreate(['code' => 'FACT-ELECT-M'], [
            'name'              => 'Facturación electrónica mensual',
            'type'              => 'recurring',
            'period'            => 'monthly',
            'price_without_iva' => 8.70,
            'iva_rate'          => 15.00,
            'auto_block'        => false,
            'grace_days'        => 5,
            'status'            => 'active',
        ]);

        // ---- Group 1: Farmacias El Cisne ----
        $group1 = BusinessGroup::firstOrCreate(['code' => 'GRP-001'], [
            'name'       => 'Farmacias El Cisne',
            'status'     => 'active',
            'created_by' => $admin->id,
        ]);

        $entity1a = LegalEntity::firstOrCreate(['ruc' => '0991234567001'], [
            'business_group_id'   => $group1->id,
            'legal_name'          => 'Farmacias El Cisne S.A.',
            'trade_name'          => 'El Cisne',
            'address'             => 'Av. Principal 123, Guayaquil',
            'phone'               => '042234567',
            'email'               => 'facturacion@elcisne.com',
            'required_accounting' => true,
            'taxpayer_type'       => 'juridical',
            'status'              => 'active',
            'created_by'          => $admin->id,
        ]);

        $entity1b = LegalEntity::firstOrCreate(['ruc' => '0997654321001'], [
            'business_group_id'   => $group1->id,
            'legal_name'          => 'Distribuidora Cisne Cía. Ltda.',
            'trade_name'          => 'Cisne Distribución',
            'address'             => 'Km 3.5 Vía Daule, Guayaquil',
            'phone'               => '042345678',
            'email'               => 'admin@cisnedist.com',
            'required_accounting' => true,
            'taxpayer_type'       => 'juridical',
            'status'              => 'active',
            'created_by'          => $admin->id,
        ]);

        // 5 branches — exactly as in the PDF example
        $branch1 = Branch::firstOrCreate(['code' => 'SUC-001'], [
            'legal_entity_id'   => $entity1a->id,
            'business_group_id' => $group1->id,
            'name'              => 'Sucursal Centro',
            'address'           => 'Cdla Kennedy Norte, Local 15',
            'city'              => 'Guayaquil',
            'phone'             => '0998881111',
            'whatsapp'          => '593998881111',
            'responsible_name'  => 'María González',
            'status'            => 'active',
            'service_start_date'=> Carbon::now()->subMonths(6),
            'billing_day'       => 1,
            'next_billing_date' => Carbon::now()->startOfMonth()->addMonth(),
            'created_by'        => $admin->id,
        ]);

        $branch2 = Branch::firstOrCreate(['code' => 'SUC-002'], [
            'legal_entity_id'   => $entity1a->id,
            'business_group_id' => $group1->id,
            'name'              => 'Sucursal Norte',
            'city'              => 'Guayaquil',
            'whatsapp'          => '593998882222',
            'responsible_name'  => 'Juan Pérez',
            'status'            => 'active',
            'billing_day'       => 1,
            'next_billing_date' => Carbon::now()->startOfYear()->addYear(),
            'created_by'        => $admin->id,
        ]);

        $branch3 = Branch::firstOrCreate(['code' => 'SUC-003'], [
            'legal_entity_id'   => $entity1a->id,
            'business_group_id' => $group1->id,
            'name'              => 'Sucursal Sur',
            'city'              => 'Guayaquil',
            'status'            => 'active',
            'billing_day'       => 15,
            'next_billing_date' => Carbon::now()->startOfMonth()->addDays(14),
            'created_by'        => $admin->id,
        ]);

        $branch4 = Branch::firstOrCreate(['code' => 'SUC-004'], [
            'legal_entity_id'   => $entity1b->id,
            'business_group_id' => $group1->id,
            'name'              => 'Sucursal Este (RUC 2)',
            'city'              => 'Guayaquil',
            'whatsapp'          => '593998234567',
            'responsible_name'  => 'Carlos Mendoza',
            'status'            => 'active',
            'billing_day'       => 1,
            'next_billing_date' => Carbon::now()->startOfMonth()->addMonth(),
            'created_by'        => $admin->id,
        ]);

        $branch5 = Branch::firstOrCreate(['code' => 'SUC-005'], [
            'legal_entity_id'   => $entity1b->id,
            'business_group_id' => $group1->id,
            'name'              => 'Sucursal Mall del Sol',
            'city'              => 'Guayaquil',
            'status'            => 'blocked',
            'billing_day'       => 1,
            'next_billing_date' => Carbon::now()->startOfMonth()->addMonth(),
            'created_by'        => $admin->id,
        ]);

        // Contracted services for branches
        ContractedService::firstOrCreate(
            ['branch_id' => $branch1->id, 'plan_id' => $planPosMonthly->id],
            [
                'business_group_id' => $group1->id,
                'legal_entity_id'   => $entity1a->id,
                'start_date'        => Carbon::now()->subMonths(6),
                'period'            => 'monthly',
                'value'             => 21.74,
                'iva_amount'        => 3.26,
                'total_value'       => 25.00,
                'billing_day'       => 1,
                'next_invoice_date' => Carbon::now()->startOfMonth()->addMonth(),
                'status'            => 'active',
            ]
        );

        ContractedService::firstOrCreate(
            ['branch_id' => $branch1->id, 'plan_id' => $planFactElect->id],
            [
                'business_group_id' => $group1->id,
                'legal_entity_id'   => $entity1a->id,
                'start_date'        => Carbon::now()->subMonths(6),
                'period'            => 'monthly',
                'value'             => 8.70,
                'iva_amount'        => 1.30,
                'total_value'       => 10.00,
                'billing_day'       => 1,
                'next_invoice_date' => Carbon::now()->startOfMonth()->addMonth(),
                'status'            => 'active',
            ]
        );

        ContractedService::firstOrCreate(
            ['branch_id' => $branch2->id, 'plan_id' => $planPosAnnual->id],
            [
                'business_group_id' => $group1->id,
                'legal_entity_id'   => $entity1a->id,
                'start_date'        => Carbon::now()->startOfYear(),
                'period'            => 'annual',
                'value'             => 173.91,
                'iva_amount'        => 26.09,
                'total_value'       => 200.00,
                'billing_day'       => 1,
                'next_invoice_date' => Carbon::now()->startOfYear()->addYear(),
                'status'            => 'active',
            ]
        );

        // Contacts
        Contact::firstOrCreate(['whatsapp' => '593998881111'], [
            'business_group_id'   => $group1->id,
            'legal_entity_id'     => $entity1a->id,
            'branch_id'           => $branch1->id,
            'name'                => 'María González',
            'phone'               => '0998881111',
            'email'               => 'mgonzalez@elcisne.com',
            'position'            => 'Administradora',
            'authorized_support'  => true,
            'authorized_invoices' => true,
            'authorized_quotes'   => true,
            'type'                => 'employee',
            'status'              => 'active',
        ]);

        Contact::firstOrCreate(['whatsapp' => '593998234567'], [
            'business_group_id'   => $group1->id,
            'legal_entity_id'     => $entity1b->id,
            'branch_id'           => $branch4->id,
            'name'                => 'Carlos Mendoza',
            'phone'               => '0998234567',
            'email'               => 'cmendoza@cisnedist.com',
            'position'            => 'Gerente sucursal',
            'authorized_support'  => true,
            'authorized_invoices' => false,
            'authorized_quotes'   => false,
            'type'                => 'employee',
            'status'              => 'active',
        ]);

        // ---- Group 2: Grupo Mi Ángel de la Guarda ----
        $group2 = BusinessGroup::firstOrCreate(['code' => 'GRP-002'], [
            'name'       => 'Grupo Mi Ángel de la Guarda',
            'status'     => 'active',
            'created_by' => $admin->id,
        ]);

        $entity2 = LegalEntity::firstOrCreate(['ruc' => '1791234560001'], [
            'business_group_id' => $group2->id,
            'legal_name'        => 'Mi Ángel de la Guarda S.A.',
            'trade_name'        => 'Ángel Farma',
            'address'           => 'Av. 6 de Diciembre 789, Quito',
            'status'            => 'active',
            'created_by'        => $admin->id,
        ]);

        // ---- WhatsApp numbers ----
        WhatsappNumber::firstOrCreate(['phone_number_id' => 'PHONE_NUMBER_ID_1'], [
            'name'        => 'Soporte Técnico',
            'phone_number' => '0995467340',
            'purpose'     => 'support',
            'is_active'   => true,
        ]);

        WhatsappNumber::firstOrCreate(['phone_number_id' => 'PHONE_NUMBER_ID_2'], [
            'name'        => 'Ventas y Nuevos Clientes',
            'phone_number' => '0995878586',
            'purpose'     => 'sales',
            'is_active'   => true,
        ]);

        $this->command->info('✅ Database seeded with ASOIINFO sample data');
        $this->command->info('   Admin login: admin@asoiinfo.com / Admin2026!');
        $this->command->info('   Agent login: asesor@asoiinfo.com / Agent2026!');
        $this->command->info('   Accounting:  contabilidad@asoiinfo.com / Conta2026!');
    }
}
