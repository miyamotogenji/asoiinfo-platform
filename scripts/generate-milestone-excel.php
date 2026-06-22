<?php
/**
 * ASOIINFO Platform — 20-Day Milestone Plan
 * Matches client template: M0–M8, 7 sheets, teal/navy headers
 */
require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// ─── Color palette (matches template) ────────────────────────────────────────
define('TEAL',   '1B6B6B');   // dark teal — main headers
define('NAVY',   '1B3A5C');   // dark navy — column headers
define('WHITE',  'FFFFFF');
define('LIGHT',  'F7F9FC');   // alternating row bg
define('GRAY1',  'E8EDF2');   // row stripe
define('TEXT',   '2C3E50');   // body text
define('MUTED',  '7F8C8D');   // subtitle text
define('DONE_BG','27AE60');   define('DONE_FG','FFFFFF');
define('PEND_BG','E67E22');   define('PEND_FG','FFFFFF');
define('PART_BG','F1C40F');   define('PART_FG','7D6608');
define('OPT_BG', 'BDC3C7');   define('OPT_FG', '5D6D7E');
define('CRIT_BG','E74C3C');   define('CRIT_FG','FFFFFF');
define('REC_BG', 'F39C12');   define('REC_FG', 'FFFFFF');
define('YES_BG', 'FADBD8');   define('YES_FG', 'C0392B');

// ─── Helpers ──────────────────────────────────────────────────────────────────
function bg($c) {
    return ['fill'=>['fillType'=>Fill::FILL_SOLID,'startColor'=>['argb'=>'FF'.$c]]];
}
function font($c,$sz=10,$bold=false,$italic=false) {
    return ['font'=>['name'=>'Calibri','size'=>$sz,'bold'=>$bold,'italic'=>$italic,
                     'color'=>['argb'=>'FF'.$c]]];
}
function align($h=Alignment::HORIZONTAL_LEFT,$wrap=false) {
    return ['alignment'=>['horizontal'=>$h,'vertical'=>Alignment::VERTICAL_CENTER,'wrapText'=>$wrap]];
}
function borders($style=Border::BORDER_HAIR,$c='D5D8DC') {
    return ['borders'=>['allBorders'=>['borderStyle'=>$style,'color'=>['argb'=>'FF'.$c]]]];
}
// Write a styled header row (merged A–D)
function sectionHeader($ws,$row,$text,$colSpan='A1:D1') {
    $range = 'A'.$row.':'.substr($colSpan,-2,1).$row;
    // just use passed range end col
    $end = strlen($colSpan)>4 ? substr($colSpan,3,1) : 'D';
    $ws->mergeCells('A'.$row.':'.$end.$row);
    $ws->getCell('A'.$row)->setValue($text);
    $ws->getCell('A'.$row)->getStyle()->applyFromArray(array_merge(
        bg(TEAL), font(WHITE,14,true),
        align(Alignment::HORIZONTAL_LEFT)
    ));
    $ws->getRowDimension($row)->setRowHeight(32);
}
function subHeader($ws,$row,$text,$end='D') {
    $ws->mergeCells('A'.$row.':'.$end.$row);
    $ws->getCell('A'.$row)->setValue($text);
    $ws->getCell('A'.$row)->getStyle()->applyFromArray(array_merge(
        bg(WHITE), font(MUTED,9,false,true),
        align(Alignment::HORIZONTAL_LEFT)
    ));
    $ws->getRowDimension($row)->setRowHeight(16);
}
function colHeaders($ws,$row,$cols,$end='D') {
    foreach ($cols as $c=>$h) {
        $ws->getCell("{$c}{$row}")->setValue($h);
        $ws->getCell("{$c}{$row}")->getStyle()->applyFromArray(array_merge(
            bg(NAVY), font(WHITE,9,true),
            align(Alignment::HORIZONTAL_CENTER),
            borders(Border::BORDER_THIN,'1B3A5C')
        ));
    }
    $ws->getRowDimension($row)->setRowHeight(18);
}
function statusCell($ws,$cell,$status) {
    $map = [
        'DONE'        =>[DONE_BG,DONE_FG],
        'Pending'     =>[PEND_BG,PEND_FG],
        'Partial'     =>[PART_BG,PART_FG],
        'Optional'    =>[OPT_BG, OPT_FG],
        'CRITICAL'    =>[CRIT_BG,CRIT_FG],
        'Recommended' =>[REC_BG, REC_FG],
        'Yes'         =>[YES_BG, YES_FG],
    ];
    [$bg,$fg] = $map[$status] ?? [GRAY1,TEXT];
    $ws->getCell($cell)->setValue($status);
    $ws->getCell($cell)->getStyle()->applyFromArray(array_merge(
        bg($bg), font($fg,9,true),
        align(Alignment::HORIZONTAL_CENTER),
        borders()
    ));
}
function dataRow($ws,$row,$cells,$isEven=false) {
    $rowBg = $isEven ? LIGHT : WHITE;
    foreach ($cells as $col=>$val) {
        $ws->getCell("{$col}{$row}")->setValue($val);
        $ws->getCell("{$col}{$row}")->getStyle()->applyFromArray(array_merge(
            bg($rowBg), font(TEXT,10),
            align(Alignment::HORIZONTAL_LEFT,true),
            borders()
        ));
    }
    $ws->getRowDimension($row)->setRowHeight(17);
}
function mTag($ws,$cell,$m,$color=TEAL) {
    $ws->getCell($cell)->setValue($m);
    $ws->getCell($cell)->getStyle()->applyFromArray(array_merge(
        bg($color), font(WHITE,9,true),
        align(Alignment::HORIZONTAL_CENTER),
        borders()
    ));
}

// ═══════════════════════════════════════════════════════════════════════════════
$ss = new Spreadsheet();
$ss->getProperties()->setTitle('ASOIINFO Platform — 20-Day Milestone Plan');

// ═══════════════════════════════════════════════════════════════════════════════
// SHEET 1 — Project Summary
// ═══════════════════════════════════════════════════════════════════════════════
$s1 = $ss->getActiveSheet()->setTitle('Project Summary');
$s1->getColumnDimension('A')->setWidth(20);
$s1->getColumnDimension('B')->setWidth(42);
$s1->getColumnDimension('C')->setWidth(12);
$s1->getColumnDimension('D')->setWidth(16);

sectionHeader($s1,1,'ASOIINFO Platform — Milestone Plan','A1:D1');
subHeader($s1,2,'Client: ILBER MORALES / ASOIINFO   Budget: USD 1,200   Stack: Laravel 11 + PostgreSQL + REST API','D');

// Info block
$info = [
    ['Timeline',        '20 working days (full project)'],
    ['Marketing Site',  'https://www.asoiinfo.com/index.html (public — not replaced)'],
    ['Facturero LC',    'https://factumyc.com/login (integrate in M3)'],
    ['New Platform URL','crm.asoiinfo.com or similar (deploy in M8)'],
    ['Legacy — PowerBuilder','Data migration in M8'],
    ['Legacy — Spartha POS', 'Block / license sync in M5'],
    ['WhatsApp CRM',    '2+ numbers — Milestone M6'],
    ['Ideal Flow (PDF)','Client → Plan → Invoice → CxC → Payment → Reconcile → Active/Blocked → WhatsApp → History'],
];
$r = 4;
foreach ($info as $i => $row) {
    $ws = $s1; $even = ($i%2===0);
    $ws->getCell("A{$r}")->setValue($row[0]);
    $ws->getCell("B{$r}")->setValue($row[1]);
    $ws->getCell("A{$r}")->getStyle()->applyFromArray(array_merge(bg($even?LIGHT:WHITE),font(TEXT,10,true),align()));
    $ws->getCell("B{$r}")->getStyle()->applyFromArray(array_merge(bg($even?LIGHT:WHITE),font(TEXT,10),align(Alignment::HORIZONTAL_LEFT,true)));
    $ws->getRowDimension($r)->setRowHeight(17);
    $r++;
}

// Milestone progress table
$r += 1;
$s1->mergeCells("A{$r}:D{$r}");
$s1->getCell("A{$r}")->setValue('Milestone Progress');
$s1->getCell("A{$r}")->getStyle()->applyFromArray(array_merge(bg('D4E6F1'),font(NAVY,11,true),align()));
$s1->getRowDimension($r)->setRowHeight(22);
$r++;

colHeaders($s1,$r,['A'=>'Milestone','B'=>'Name','C'=>'Status','D'=>'Current Focus'],'D');
$r++;

$milestones = [
    ['M0','Foundation & Architecture',    'DONE',   'Laravel 11 scaffold, auth, REST API, DB schema'],
    ['M1','Multi-Company Base',           'DONE',   'Groups, entities, branches, contacts, plans, reports'],
    ['M2','Plans & Services',             'Pending','Plans catalog + contracted services + billing calendar'],
    ['M3','Billing & CxC + Facturero',    'Pending','Invoice queue + CxC + PDF + Facturero stub'],
    ['M4','Payments & Gateway',           'Pending','Payment registration + webhook endpoint + reconciliation'],
    ['M5','Blocking + Spartha',           'Pending','Block/unblock rules + Spartha POS API integration'],
    ['M6','WhatsApp CRM',                 'Pending','WhatsApp Cloud API, dual inbox, attend workflow'],
    ['M7','Quotes, Reports, AI',          'Pending','Quotes, support tickets, reports dashboard, AI suggest-reply'],
    ['M8','Deploy & Handover',            'Pending','VPS deploy + domain + SSL + training + source handover'],
    ['',  'TOTAL','','20 days  ·  USD 1,200'],
];
foreach ($milestones as $i=>$m) {
    mTag($s1,"A{$r}",$m[0],$m[0]==='M0'||$m[0]==='M1'?TEAL:NAVY);
    $s1->getCell("B{$r}")->setValue($m[1]);
    $s1->getCell("B{$r}")->getStyle()->applyFromArray(array_merge(bg($i%2===0?LIGHT:WHITE),font(TEXT,10,$m[0]===''?true:false),align(Alignment::HORIZONTAL_LEFT,true),borders()));
    statusCell($s1,"C{$r}",$m[2]);
    $s1->getCell("D{$r}")->setValue($m[3]);
    $s1->getCell("D{$r}")->getStyle()->applyFromArray(array_merge(bg($i%2===0?LIGHT:WHITE),font(TEXT,9),align(Alignment::HORIZONTAL_LEFT,true),borders()));
    $s1->getRowDimension($r)->setRowHeight(17);
    $r++;
}

// ═══════════════════════════════════════════════════════════════════════════════
// SHEET 2 — Milestones
// ═══════════════════════════════════════════════════════════════════════════════
$s2 = $ss->createSheet()->setTitle('Milestones');
$s2->getColumnDimension('A')->setWidth(8);
$s2->getColumnDimension('B')->setWidth(28);
$s2->getColumnDimension('C')->setWidth(12);
$s2->getColumnDimension('D')->setWidth(42);

sectionHeader($s2,1,'Milestone Detail','A1:D1');
subHeader($s2,2,'M0 & M1 completed and live for demo today — M2 through M8 scheduled over 18 remaining days','D');
colHeaders($s2,3,['A'=>'M#','B'=>'Milestone Name','C'=>'Status','D'=>'Key Deliverables'],'D');

$msDetail = [
    ['M0','Foundation & Architecture','DONE',
        'Laravel 11 scaffold · PostgreSQL schema · Sanctum auth · Spatie RBAC · REST API skeleton · Branded login · Docker-compose · docs/M0-ARCHITECTURE.md'],
    ['M1','Multi-Company Base','DONE',
        'Business Groups CRUD · Legal Entities (RUC) CRUD · Branches + block/unblock + 360° view · Contacts · Plans catalog · Contracted services · Financial report · Support report · Demo ASOIINFO data seeded'],
    ['M2','Plans & Services','Pending',
        'Plan pricing + IVA config · Billing day / grace period · Service assignment per branch · Billing calendar preview'],
    ['M3','Billing & CxC + Facturero','Pending',
        'Invoice PDF generation · Auto monthly billing scheduler · Accounts Receivable (CxC) management · Facturero LC stub integration'],
    ['M4','Payments & Gateway','Pending',
        'Payment registration screen · PayPhone / bank webhook endpoint · Approve/reject payments · Reconciliation dashboard'],
    ['M5','Blocking + Spartha','Pending',
        'Auto-block after N overdue days · Manual block override · Spartha POS license sync API · Block audit log'],
    ['M6','WhatsApp CRM','Pending',
        'Meta WhatsApp Cloud API · Support tray + Sales tray · Attend / transfer / close · Send invoice PDF via chat · Multi-number support (2+ numbers) · Client lookup from phone'],
    ['M7','Quotes, Reports, AI','Pending',
        'Quote builder + PDF send · Support tickets · Document attach · Reports dashboard · AI suggest-reply (OpenAI optional)'],
    ['M8','Deploy & Handover','Pending',
        'VPS server setup · crm.asoiinfo.com domain + SSL · PostgreSQL production · Performance tuning · Documentation + client training · Source code handover'],
];
$r = 4;
foreach ($msDetail as $i=>$m) {
    mTag($s2,"A{$r}",$m[0],$m[2]==='DONE'?TEAL:NAVY);
    $s2->getCell("B{$r}")->setValue($m[1]);
    $s2->getCell("C{$r}")->setValue(''); // filled by statusCell
    statusCell($s2,"C{$r}",$m[2]);
    $s2->getCell("D{$r}")->setValue($m[3]);
    foreach (['B','D'] as $c) {
        $s2->getCell("{$c}{$r}")->getStyle()->applyFromArray(array_merge(bg($i%2===0?LIGHT:WHITE),font(TEXT,10),align(Alignment::HORIZONTAL_LEFT,true),borders()));
    }
    $s2->getRowDimension($r)->setRowHeight(22);
    $r++;
}

// ═══════════════════════════════════════════════════════════════════════════════
// SHEET 3 — PDF Requirements Mapping
// ═══════════════════════════════════════════════════════════════════════════════
$s3 = $ss->createSheet()->setTitle('PDF Requirements');
$s3->getColumnDimension('A')->setWidth(46);
$s3->getColumnDimension('B')->setWidth(12);
$s3->getColumnDimension('C')->setWidth(12);
$s3->getColumnDimension('D')->setWidth(38);

sectionHeader($s3,1,'PDF Requirements Mapping','A1:D1');
subHeader($s3,2,'CHATBOT CRM CXC.pdf — each requirement mapped to delivery milestone','D');
colHeaders($s3,3,['A'=>'PDF Requirement (Client Document)','B'=>'Milestone','C'=>'Status','D'=>'Notes'],'D');

$pdfReqs = [
    ['Crear grupos empresariales, empresas legales, sucursales y contactos','M1','DONE','Full CRUD live — /grupos, /empresas, /sucursales, /contactos'],
    ['Administrar planes mensuales/anuales y servicios contratados','M2','Pending','Spartha POS, Facturero, ERP plans'],
    ['Generar automáticamente facturas recurrentes mensuales o anuales','M3','Pending','Scheduled job + approval workflow'],
    ['Controlar cuentas por cobrar — clientes al día, vencidos, bloqueados','M3, M5','Pending','CxC module + status engine'],
    ['Recibir pagos, alertas, conciliar y aprobar pagos','M4','Pending','Webhooks + reconciliation screen'],
    ['Bloquear/desbloquear clientes según estado de pago','M5','Pending','Multi-level block rules'],
    ['Integrarse con Spartha POS y sistema web','M5','Pending','Requires Spartha API docs from client'],
    ['WhatsApp Business — pantalla chatbot multiagente','M6','Pending','Support + sales trays'],
    ['Manejar varios números de WhatsApp a la vez','M6','Pending','Meta Cloud API multi-number'],
    ['Identificar quién escribe, empresa/sucursal, si está al día','M6','Pending','Phone lookup API ready in M1'],
    ['Historial completo de atenciones, asesores, archivos','M6, M7','Pending','Service history on close'],
    ['Emitir/enviar facturas y cotizaciones desde el chat','M6, M7','Pending','PDF send via WhatsApp'],
    ['Adjuntar documentos, imágenes y comprobantes','M6, M7','Pending','File storage module'],
    ['Roles, permisos, reportes e indicadores','M1, M7','Partial','Roles done M1 — reports in M7'],
    ['Integración IA — sugerencias, clasificación, resumen','M7','Pending','Human approval for sensitive topics'],
];
$r = 4;
foreach ($pdfReqs as $i=>$row) {
    dataRow($s3,$r,['A'=>$row[0],'D'=>$row[3]],$i%2===0);
    $s3->getCell("B{$r}")->setValue($row[1]);
    $s3->getCell("B{$r}")->getStyle()->applyFromArray(array_merge(bg($i%2===0?LIGHT:WHITE),font(TEAL,9,true),align(Alignment::HORIZONTAL_CENTER),borders()));
    statusCell($s3,"C{$r}",$row[2]);
    $r++;
}

// ═══════════════════════════════════════════════════════════════════════════════
// SHEET 4 — Workana Deliverables
// ═══════════════════════════════════════════════════════════════════════════════
$s4 = $ss->createSheet()->setTitle('Workana Deliverables');
$s4->getColumnDimension('A')->setWidth(32);
$s4->getColumnDimension('B')->setWidth(12);
$s4->getColumnDimension('C')->setWidth(14);
$s4->getColumnDimension('D')->setWidth(40);

sectionHeader($s4,1,'Workana Proposal Deliverables','A1:D1');
subHeader($s4,2,'Tasks included in accepted proposal — mapped to milestones','D');
colHeaders($s4,3,['A'=>'Workana Task (Proposal)','B'=>'Milestone','C'=>'Status','D'=>'Notes'],'D');

$workana = [
    ['Source file',                   'M0, M8','Partial','Full source f:\\First_Firebase\\asoiinfo-platform\\'],
    ['Hosting',                       'M8',    'Pending','VPS required — e.g. Hetzner, DigitalOcean'],
    ['Domain',                        'M8',    'Pending','Recommended: crm.asoiinfo.com'],
    ['SSL',                           'M8',    'Pending','Let\'s Encrypt on production deploy'],
    ['Chat (WhatsApp CRM)',            'M6',    'Pending','WhatsApp Business Cloud API'],
    ['Content Upload',                'M1',    'DONE',   'Demo ASOIINFO organization data loaded'],
    ['Integration payment gateway',   'M4',    'Pending','Bank/gateway webhooks'],
    ['Social media kit',              'M8',    'Optional','Marketing site stays at asoiinfo.com'],
    ['WhatsApp and Social Networks links','M6', 'Pending','Multi-number unified inbox'],
    ['Additional revision',           'All',   'Partial', 'Per milestone client review'],
    ['Responsive Design',             'M0–M8', 'Partial', 'Admin panel responsive since M0'],
    ['API Integration',               'M0–M6', 'Partial', 'Org REST API done — more in M3–M6'],
    ['Speed optimized',               'M8',    'Pending','Caching, DB indexes on deploy'],
    ['SEO structure',                 'M8',    'Optional','Public pages if needed'],
];
$r = 4;
foreach ($workana as $i=>$row) {
    dataRow($s4,$r,['A'=>$row[0],'D'=>$row[3]],$i%2===0);
    $s4->getCell("B{$r}")->setValue($row[1]);
    $s4->getCell("B{$r}")->getStyle()->applyFromArray(array_merge(bg($i%2===0?LIGHT:WHITE),font(TEAL,9,true),align(Alignment::HORIZONTAL_CENTER),borders()));
    statusCell($s4,"C{$r}",$row[2]);
    $r++;
}

// ═══════════════════════════════════════════════════════════════════════════════
// SHEET 5 — Client Requirements
// ═══════════════════════════════════════════════════════════════════════════════
$s5 = $ss->createSheet()->setTitle('Client Requirements');
$s5->getColumnDimension('A')->setWidth(10);
$s5->getColumnDimension('B')->setWidth(40);
$s5->getColumnDimension('C')->setWidth(14);
$s5->getColumnDimension('D')->setWidth(34);

sectionHeader($s5,1,'Client Input Required Per Milestone','A1:D1');
subHeader($s5,2,'Send this list to Ilber Morales — delays block corresponding modules','D');
colHeaders($s5,3,['A'=>'Milestone','B'=>'What Client Must Provide','C'=>'Required?','D'=>'If Not Provided'],'D');

$clientReqs = [
    ['M0', 'Confirm project start',                          'Yes',         'Project wait'],
    ['M1', 'Excel/CSV: companies, branches, contacts, phones','Recommended', 'Demo data used (current)'],
    ['M1', 'Staff users list (name, email, role)',            'Optional',    'Admin account only'],
    ['M2', 'Plan names + prices (Spartha, Facturero, ERP)',   'Optional',    'Sample plans created'],
    ['M2', 'Billing day rule (e.g. 1st of month)',            'Optional',    'Default: day 1'],
    ['M3', 'Facturero test login — factumyc.com',             'Yes',         'Manual PDF invoices only'],
    ['M3', 'IVA rate + invoice number format',               'Optional',    '12% Ecuador default'],
    ['M4', 'Bank / payment gateway API documentation',       'Recommended', 'Manual payment entry'],
    ['M5', 'Spartha API documentation or technical contact', 'Yes',         'Manual block sync only'],
    ['M6', 'Meta Business Manager + WhatsApp API access',    'CRITICAL',    'Blocks chat — add 3–7 days'],
    ['M6', '2 WhatsApp numbers (support + sales)',           'CRITICAL',    'Blocks M6 entirely'],
    ['M7', 'OpenAI API key (AI features)',                   'Optional',    'AI module disabled'],
    ['M8', 'Domain name + VPS/server SSH access',            'Yes',         'Local demo only'],
    ['M8', 'PowerBuilder database export',                   'Optional',    'CSV import template provided'],
];
$r = 4;
foreach ($clientReqs as $i=>$row) {
    $s5->getCell("A{$r}")->setValue($row[0]);
    $s5->getCell("A{$r}")->getStyle()->applyFromArray(array_merge(bg(TEAL),font(WHITE,9,true),align(Alignment::HORIZONTAL_CENTER),borders()));
    dataRow($s5,$r,['B'=>$row[1],'D'=>$row[3]],$i%2===0);
    statusCell($s5,"C{$r}",$row[2]);
    $r++;
}

// ═══════════════════════════════════════════════════════════════════════════════
// SHEET 6 — M0 & M1 Completed (Demo Script)
// ═══════════════════════════════════════════════════════════════════════════════
$s6 = $ss->createSheet()->setTitle('M0 & M1 Completed');
$s6->getColumnDimension('A')->setWidth(8);
$s6->getColumnDimension('B')->setWidth(36);
$s6->getColumnDimension('C')->setWidth(10);
$s6->getColumnDimension('D')->setWidth(42);

sectionHeader($s6,1,'Completed Work — M0 & M1 (Ready for Client Demo)','A1:D1');
subHeader($s6,2,'Login: admin@asoiinfo.com   Password: Admin2026!   Local: http://127.0.0.1:8000/login','D');
colHeaders($s6,3,['A'=>'Milestone','B'=>'Deliverable','C'=>'Status','D'=>'Details / URL'],'D');

$completed = [
    ['M0','Laravel 11 project scaffold',               'DONE','f:\\First_Firebase\\asoiinfo-platform\\'],
    ['M0','Branded login page',                        'DONE','/login — ASOIINFO blue theme'],
    ['M0','Database schema (PostgreSQL ready)',        'DONE','docker-compose.yml included'],
    ['M0','REST API health endpoint',                  'DONE','GET /api/v1/health'],
    ['M0','Architecture documentation',               'DONE','docs/M0-ARCHITECTURE.md'],
    ['M1','Grupos empresariales — full CRUD',          'DONE','/admin/grupos'],
    ['M1','Empresas legales — full CRUD',              'DONE','/admin/empresas'],
    ['M1','Sucursales — full CRUD + block/unblock',    'DONE','/admin/sucursales'],
    ['M1','Contactos — phone + WhatsApp',              'DONE','/admin/contactos'],
    ['M1','Planes — catalog CRUD',                     'DONE','/admin/planes'],
    ['M1','Servicios contratados por sucursal',        'DONE','/admin/servicios'],
    ['M1','Usuarios y 6 roles (RBAC)',                 'DONE','/admin/usuarios (Spatie)'],
    ['M1','Reporte Financiero (MRR, tendencias)',      'DONE','/admin/reportes/financiero'],
    ['M1','Reporte Soporte (agentes, tiempos)',        'DONE','/admin/reportes/soporte'],
    ['M1','REST API organization endpoints',           'DONE','/api/v1/contacts/lookup/{phone}'],
    ['M1','Demo ASOIINFO data (Quito, Guayaquil)',     'DONE','0995878586, 0995467340'],
    ['M1','Responsive admin dashboard',                'DONE','/admin/dashboard — KPIs live'],
];
$r = 4;
foreach ($completed as $i=>$row) {
    $s6->getCell("A{$r}")->setValue($row[0]);
    $s6->getCell("A{$r}")->getStyle()->applyFromArray(array_merge(bg(TEAL),font(WHITE,9,true),align(Alignment::HORIZONTAL_CENTER),borders()));
    dataRow($s6,$r,['B'=>$row[1],'D'=>$row[3]],$i%2===0);
    statusCell($s6,"C{$r}",'DONE');
    $r++;
}

// Footer note
$r++;
$s6->mergeCells("A{$r}:D{$r}");
$s6->getCell("A{$r}")->setValue('  Phase 2+ features (M2–M8) are disabled and show "Coming Soon" pages with timeline info. Nothing broken — by design.');
$s6->getCell("A{$r}")->getStyle()->applyFromArray(array_merge(bg('D5F5E3'),font('1E8449',9,false,true),align()));
$s6->getRowDimension($r)->setRowHeight(18);

// ═══════════════════════════════════════════════════════════════════════════════
// SHEET 7 — 20-Day Calendar
// ═══════════════════════════════════════════════════════════════════════════════
$s7 = $ss->createSheet()->setTitle('20-Day Calendar');
$s7->getColumnDimension('A')->setWidth(7);
$s7->getColumnDimension('B')->setWidth(10);
$s7->getColumnDimension('C')->setWidth(44);
$s7->getColumnDimension('D')->setWidth(12);

sectionHeader($s7,1,'20-Day Development Calendar','A1:D1');
subHeader($s7,2,'Full project schedule — USD 1,200 total across all milestones','D');
colHeaders($s7,3,['A'=>'Day','B'=>'Milestone','C'=>'Focus Area','D'=>'Cumulative'],'D');

$calendar = [
    [1, 'M0','Laravel 11 + PostgreSQL + authentication + API skeleton',    'Day 1  ✓'],
    [2, 'M1','Multi-company CRUD — groups, companies',                     'Day 2  ✓'],
    [3, 'M1','Branches, contacts, users, roles, audit log',               'Day 3  ✓'],
    [4, 'M2','Plans catalog + contracted services + billing calendar',     'Day 4'],
    [5, 'M3','Invoice queue + accounts receivable (part 1)',               'Day 5'],
    [6, 'M3','CxC statuses + PDF invoices + Facturero stub',               'Day 6'],
    [7, 'M4','Payment registration + webhook endpoint',                    'Day 7'],
    [8, 'M4','Approve/reject + reconciliation screen',                     'Day 8'],
    [9, 'M5','Block/unblock rules + Spartha API integration',              'Day 9'],
    [10,'M6','WhatsApp Cloud API — send/receive messages',                 'Day 10'],
    [11,'M6','Support tray + sales tray UI panels',                       'Day 11'],
    [12,'M6','Attend workflow — read without marking read',               'Day 12'],
    [13,'M6','Client lookup + files + service history',                   'Day 13'],
    [14,'M7','Quotes + support tickets + document attach',                 'Day 14'],
    [15,'M7','Reports dashboard + optional AI suggest-reply',              'Day 15'],
    [16,'M8','VPS deploy + domain + SSL + performance',                    'Day 16'],
    [17,'M8','Documentation + source handover + client training',          'Day 17'],
    [18,'M8','Production QA + final bug fixes',                            'Day 18'],
    [19,'M8','Client acceptance testing (UAT)',                            'Day 19'],
    [20,'M8','Go-live + post-launch monitoring',                           'Day 20'],
];
$r = 4;
foreach ($calendar as $i=>$row) {
    $done = $row[0] <= 3;
    $mColor = $done ? TEAL : NAVY;
    $s7->getCell("A{$r}")->setValue($row[0]);
    $s7->getCell("A{$r}")->getStyle()->applyFromArray(array_merge(
        bg($done?TEAL:($i%2===0?LIGHT:WHITE)),
        font($done?WHITE:TEXT,10,true),
        align(Alignment::HORIZONTAL_CENTER),borders()
    ));
    $s7->getCell("B{$r}")->setValue($row[1]);
    $s7->getCell("B{$r}")->getStyle()->applyFromArray(array_merge(
        bg($mColor),font(WHITE,9,true),align(Alignment::HORIZONTAL_CENTER),borders()
    ));
    $s7->getCell("C{$r}")->setValue($row[2]);
    $s7->getCell("C{$r}")->getStyle()->applyFromArray(array_merge(
        bg($done?'EBF5FB':($i%2===0?LIGHT:WHITE)),font(TEXT,10),align(Alignment::HORIZONTAL_LEFT,true),borders()
    ));
    $s7->getCell("D{$r}")->setValue($row[3]);
    $s7->getCell("D{$r}")->getStyle()->applyFromArray(array_merge(
        bg($done?'D5F5E3':($i%2===0?LIGHT:WHITE)),font($done?'1E8449':MUTED,9,$done),
        align(Alignment::HORIZONTAL_CENTER),borders()
    ));
    $s7->getRowDimension($r)->setRowHeight(17);
    $r++;
}

// ─── Save ─────────────────────────────────────────────────────────────────────
$ss->setActiveSheetIndex(0);
$out = __DIR__.'/../public/ASOIINFO-Milestone-Plan-2026.xlsx';
(new Xlsx($ss))->save($out);
echo "Saved: {$out}\n";
echo "Size:  ".round(filesize($out)/1024,1)." KB\n";
echo "Sheets: ".implode(', ',array_map(fn($s)=>$s->getTitle(),$ss->getAllSheets()))."\n";
