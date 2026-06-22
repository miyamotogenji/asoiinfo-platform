<?php
/**
 * Real ASOIINFO client demo data
 * Represents actual clients managed by ASOIINFO platform
 */
require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\BusinessGroup;
use App\Models\LegalEntity;
use App\Models\Branch;
use App\Models\Contact;
use App\Models\Plan;
use App\Models\ContractedService;
use Carbon\Carbon;

DB::statement('PRAGMA foreign_keys = OFF');

// ── Clear old demo data ───────────────────────────────────────────────────────
DB::table('contracted_services')->delete();
DB::table('contacts')->delete();
DB::table('branches')->delete();
DB::table('legal_entities')->delete();
DB::table('business_groups')->delete();
DB::table('plans')->delete();

DB::statement('PRAGMA foreign_keys = ON');

echo "Old data cleared.\n";

// ── Plans (ASOIINFO real service catalog) ────────────────────────────────────
// columns: code, name, type, period, price_without_iva, iva_rate, total_price,
//          billable_product, auto_block, grace_days, billing_day_suggestion, status, description
$mk = function(array $d): Plan {
    $net   = $d['price_without_iva'];
    $iva   = $d['iva_rate'] ?? 15;
    $total = round($net * (1 + $iva / 100), 2);
    return Plan::create(array_merge([
        'iva_rate'              => $iva,
        'total_price'           => $total,
        'billable_product'      => 'Servicio tecnológico',
        'auto_block'            => true,
        'grace_days'            => 5,
        'billing_day_suggestion'=> 1,
        'status'                => 'active',
        'type'                  => 'recurring',
    ], $d));
};

$plans = [
    $mk(['code'=>'SPARTHA-M','name'=>'Spartha POS — Mensual',              'period'=>'monthly','price_without_iva'=>45.00, 'description'=>'Licencia mensual Spartha POS con soporte técnico incluido']),
    $mk(['code'=>'SPARTHA-A','name'=>'Spartha POS — Anual',                'period'=>'annual', 'price_without_iva'=>460.00,'description'=>'Licencia anual Spartha POS — ahorro del 15%','grace_days'=>30]),
    $mk(['code'=>'FACT-M',   'name'=>'Facturación Electrónica — Mensual',  'period'=>'monthly','price_without_iva'=>28.00, 'description'=>'Emisión ilimitada de facturas SRI + soporte']),
    $mk(['code'=>'WEB-M',    'name'=>'Sistema Web Empresarial',             'period'=>'monthly','price_without_iva'=>85.00, 'description'=>'Portal web + catálogo + pedidos en línea']),
    $mk(['code'=>'COMBO-PRO','name'=>'Pack Profesional (POS+Fact+Web)',     'period'=>'monthly','price_without_iva'=>140.00,'description'=>'Bundle completo: Spartha POS + Facturación + Sistema web']),
];

$sparthaPlan = $plans[0];
$factPlan    = $plans[2];
$comboPlan   = $plans[4];

echo "Plans created: " . count($plans) . "\n";

// ── Helper ────────────────────────────────────────────────────────────────────
$adminId = \App\Models\User::first()->id;

function makeBranch(array $data, int $adminId): Branch {
    $day  = $data['billing_day'] ?? 1;
    $next = Carbon::now()->startOfMonth()->day($day);
    if ($next->isPast()) $next->addMonth();

    return Branch::create(array_merge([
        'billing_day'        => $day,
        'next_billing_date'  => $next,
        'status'             => 'active',
        'created_by'         => $adminId,
        'service_start_date' => Carbon::now()->subMonths(rand(2,8)),
    ], $data));
}

function addService(Branch $branch, Plan $plan, string $status='active'): void {
    ContractedService::create([
        'branch_id'         => $branch->id,
        'legal_entity_id'   => $branch->legal_entity_id,
        'business_group_id' => $branch->business_group_id,
        'plan_id'           => $plan->id,
        'status'            => $status,
        'period'            => $plan->period,
        'start_date'        => Carbon::now()->subMonths(rand(1,6)),
        'next_invoice_date' => Carbon::now()->startOfMonth()->addMonth(),
        'value'             => $plan->price_without_iva,
        'iva_amount'        => round($plan->price_without_iva * $plan->iva_rate / 100, 2),
        'total_value'       => $plan->total_price,
        'billing_day'       => $branch->billing_day ?? 1,
        'grace_days'        => $plan->grace_days,
        'auto_block'        => $plan->auto_block,
        'created_by'        => 1,
    ]);
}

// ════════════════════════════════════════════════════════════════════════════
// GROUP 1 — Distribuidora MAXIFARM (pharmacy chain, Guayaquil)
// ════════════════════════════════════════════════════════════════════════════
$g1 = BusinessGroup::create([
    'code'       => 'GRP-MAXI',
    'name'       => 'Grupo MAXIFARM Ecuador',
    'status'     => 'active',
    'observations'=> 'Cadena de farmacias, cliente desde 2023. Pack profesional.',
    'created_by' => $adminId,
]);

$e1 = LegalEntity::create([
    'business_group_id' => $g1->id,
    'ruc'               => '0991847320001',
    'legal_name'        => 'MAXIFARM S.A.',
    'trade_name'        => 'Farmacias MAXIFARM',
    'address'           => 'Av. 9 de Octubre 1234, piso 3',
    'city'              => 'Guayaquil',
    'phone'             => '042-234567',
    'email'             => 'admin@maxifarm.ec',
    'status'            => 'active',
]);

$b1 = makeBranch(['legal_entity_id'=>$e1->id,'business_group_id'=>$g1->id,'code'=>'MAXI-001','name'=>'MAXIFARM Centro','city'=>'Guayaquil','address'=>'Av. 9 de Octubre 456, local 12','phone'=>'0991234501','whatsapp'=>'0991234501','responsible_name'=>'Paola Ramos','billing_day'=>1], $adminId);
$b2 = makeBranch(['legal_entity_id'=>$e1->id,'business_group_id'=>$g1->id,'code'=>'MAXI-002','name'=>'MAXIFARM Norte','city'=>'Guayaquil','address'=>'Av. Portete y Ficus, CC Ventura','phone'=>'0991234502','whatsapp'=>'0991234502','responsible_name'=>'Luis Tenorio','billing_day'=>1], $adminId);
$b3 = makeBranch(['legal_entity_id'=>$e1->id,'business_group_id'=>$g1->id,'code'=>'MAXI-003','name'=>'MAXIFARM Mall del Sol','city'=>'Guayaquil','address'=>'Mall del Sol, local G-14','phone'=>'0991234503','whatsapp'=>'0991234503','responsible_name'=>'Diana Castro','billing_day'=>1,'status'=>'blocked'], $adminId);

addService($b1, $comboPlan);
addService($b2, $comboPlan);
addService($b3, $comboPlan, 'suspended');

Contact::insert([
    ['business_group_id'=>$g1->id,'legal_entity_id'=>$e1->id,'branch_id'=>$b1->id,'name'=>'Paola Ramos','position'=>'Administradora','phone'=>'0991234501','whatsapp'=>'0991234501','email'=>'pramos@maxifarm.ec','type'=>'employee','authorized_support'=>1,'authorized_invoices'=>1,'authorized_quotes'=>0,'status'=>'active','created_by'=>1,'created_at'=>now(),'updated_at'=>now()],
    ['business_group_id'=>$g1->id,'legal_entity_id'=>$e1->id,'branch_id'=>$b1->id,'name'=>'Ilber Morales','position'=>'Gerente General','phone'=>'0995878586','whatsapp'=>'0995878586','email'=>'ilber@maxifarm.ec','type'=>'employee','authorized_support'=>1,'authorized_invoices'=>1,'authorized_quotes'=>1,'status'=>'active','created_by'=>1,'created_at'=>now(),'updated_at'=>now()],
]);

echo "Group 1 (MAXIFARM) created: 3 branches\n";

// ════════════════════════════════════════════════════════════════════════════
// GROUP 2 — TechStore Soluciones (electronics retail, Quito)
// ════════════════════════════════════════════════════════════════════════════
$g2 = BusinessGroup::create([
    'code'        => 'GRP-TECH',
    'name'        => 'TechStore Soluciones Ecuador',
    'status'      => 'active',
    'observations'=> 'Tiendas de tecnología. Spartha POS + Facturación.',
    'created_by'  => $adminId,
]);

$e2 = LegalEntity::create([
    'business_group_id' => $g2->id,
    'ruc'               => '1792034567001',
    'legal_name'        => 'TECHSTORE CÍA. LTDA.',
    'trade_name'        => 'TechStore Ecuador',
    'address'           => 'Av. Naciones Unidas N34-67 y Japón',
    'city'              => 'Quito',
    'phone'             => '022-456789',
    'email'             => 'facturacion@techstore.ec',
    'status'            => 'active',
]);

$b4 = makeBranch(['legal_entity_id'=>$e2->id,'business_group_id'=>$g2->id,'code'=>'TECH-001','name'=>'TechStore Quito Norte','city'=>'Quito','address'=>'Av. Naciones Unidas N34-67','phone'=>'0998765401','whatsapp'=>'0998765401','responsible_name'=>'Andrés Vega','billing_day'=>5], $adminId);
$b5 = makeBranch(['legal_entity_id'=>$e2->id,'business_group_id'=>$g2->id,'code'=>'TECH-002','name'=>'TechStore El Recreo','city'=>'Quito','address'=>'CC El Recreo, piso 2, local 234','phone'=>'0998765402','whatsapp'=>'0998765402','responsible_name'=>'Sofía Andrade','billing_day'=>5], $adminId);

addService($b4, $sparthaPlan);
addService($b4, $factPlan);
addService($b5, $sparthaPlan);
addService($b5, $factPlan);

Contact::insert([
    ['business_group_id'=>$g2->id,'legal_entity_id'=>$e2->id,'branch_id'=>$b4->id,'name'=>'Andrés Vega','position'=>'Gerente de tienda','phone'=>'0998765401','whatsapp'=>'0998765401','email'=>'avega@techstore.ec','type'=>'employee','authorized_support'=>1,'authorized_invoices'=>1,'authorized_quotes'=>1,'status'=>'active','created_by'=>1,'created_at'=>now(),'updated_at'=>now()],
    ['business_group_id'=>$g2->id,'legal_entity_id'=>$e2->id,'branch_id'=>$b5->id,'name'=>'Sofía Andrade','position'=>'Administradora','phone'=>'0998765402','whatsapp'=>'0998765402','email'=>'sandrade@techstore.ec','type'=>'employee','authorized_support'=>1,'authorized_invoices'=>0,'authorized_quotes'=>0,'status'=>'active','created_by'=>1,'created_at'=>now(),'updated_at'=>now()],
]);

echo "Group 2 (TechStore) created: 2 branches\n";

// ════════════════════════════════════════════════════════════════════════════
// GROUP 3 — Restaurantes La Hacienda (food chain, mixed)
// ════════════════════════════════════════════════════════════════════════════
$g3 = BusinessGroup::create([
    'code'        => 'GRP-HACI',
    'name'        => 'Grupo La Hacienda Restaurantes',
    'status'      => 'active',
    'observations'=> 'Cadena de restaurantes. Spartha POS para pedidos y caja.',
    'created_by'  => $adminId,
]);

$e3a = LegalEntity::create([
    'business_group_id' => $g3->id,
    'ruc'               => '0990123456001',
    'legal_name'        => 'HACIENDA FOOD S.A.',
    'trade_name'        => 'La Hacienda Guayaquil',
    'address'           => 'Urdesa Central, Av. Víctor Emilio Estrada 812',
    'city'              => 'Guayaquil',
    'phone'             => '042-889900',
    'email'             => 'gye@lahacienda.ec',
    'status'            => 'active',
]);

$e3b = LegalEntity::create([
    'business_group_id' => $g3->id,
    'ruc'               => '1790654321001',
    'legal_name'        => 'HACIENDA FOOD QUITO S.A.',
    'trade_name'        => 'La Hacienda Quito',
    'address'           => 'Av. González Suárez N31-33',
    'city'              => 'Quito',
    'phone'             => '022-990011',
    'email'             => 'uio@lahacienda.ec',
    'status'            => 'active',
]);

$b6 = makeBranch(['legal_entity_id'=>$e3a->id,'business_group_id'=>$g3->id,'code'=>'HACI-001','name'=>'La Hacienda Urdesa','city'=>'Guayaquil','address'=>'Av. Víctor Emilio Estrada 812','phone'=>'0994567801','whatsapp'=>'0994567801','responsible_name'=>'Carmen Flores','billing_day'=>10], $adminId);
$b7 = makeBranch(['legal_entity_id'=>$e3b->id,'business_group_id'=>$g3->id,'code'=>'HACI-002','name'=>'La Hacienda González Suárez','city'=>'Quito','address'=>'Av. González Suárez N31-33','phone'=>'0994567802','whatsapp'=>'0994567802','responsible_name'=>'Roberto Molina','billing_day'=>10], $adminId);
$b8 = makeBranch(['legal_entity_id'=>$e3b->id,'business_group_id'=>$g3->id,'code'=>'HACI-003','name'=>'La Hacienda Cumbayá','city'=>'Cumbayá','address'=>'Calle Interoceánica y Diego de Robles','phone'=>'0994567803','whatsapp'=>'0994567803','responsible_name'=>'Fernanda López','billing_day'=>10], $adminId);

addService($b6, $sparthaPlan);
addService($b7, $sparthaPlan);
addService($b8, $sparthaPlan);

Contact::insert([
    ['business_group_id'=>$g3->id,'legal_entity_id'=>$e3a->id,'branch_id'=>$b6->id,'name'=>'Carmen Flores','position'=>'Administradora GYE','phone'=>'0994567801','whatsapp'=>'0994567801','email'=>'cflores@lahacienda.ec','type'=>'employee','authorized_support'=>1,'authorized_invoices'=>1,'authorized_quotes'=>0,'status'=>'active','created_by'=>1,'created_at'=>now(),'updated_at'=>now()],
    ['business_group_id'=>$g3->id,'legal_entity_id'=>$e3b->id,'branch_id'=>$b7->id,'name'=>'Roberto Molina','position'=>'Gerente UIO','phone'=>'0994567802','whatsapp'=>'0994567802','email'=>'rmolina@lahacienda.ec','type'=>'employee','authorized_support'=>1,'authorized_invoices'=>1,'authorized_quotes'=>1,'status'=>'active','created_by'=>1,'created_at'=>now(),'updated_at'=>now()],
]);

echo "Group 3 (La Hacienda) created: 3 branches\n";

// ── Summary ───────────────────────────────────────────────────────────────────
echo "\n=== FINAL COUNT ===\n";
echo "Groups:   " . BusinessGroup::count() . "\n";
echo "Entities: " . LegalEntity::count() . "\n";
echo "Branches: " . Branch::count() . " (active: " . Branch::where('status','active')->count() . ", blocked: " . Branch::where('status','blocked')->count() . ")\n";
echo "Plans:    " . Plan::count() . "\n";
echo "Services: " . ContractedService::count() . "\n";
echo "Contacts: " . Contact::count() . "\n";
echo "\nDemo data ready for client presentation!\n";
