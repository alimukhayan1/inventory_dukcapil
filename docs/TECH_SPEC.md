# TECH SPEC — Sistem Informasi Inventaris Barang
## Kantor Cabang Disdukcapil

**Version:** 1.0  
**Status:** MVP / Kerja Praktik Mahasiswa  
**Architecture:** Monolithic Web Application  
**Backend:** Laravel  
**Admin Panel:** Filament  
**Database:** MySQL

---

# 1. Tujuan Technical Specification

Dokumen ini menerjemahkan `PRD.md` dan `ERD.md` menjadi spesifikasi teknis yang dapat langsung digunakan untuk implementasi aplikasi Laravel + Filament.

Dokumen ini berfokus pada:

- Struktur aplikasi.
- Stack teknologi.
- Konvensi coding.
- Database dan migration.
- Model dan relationship.
- Service layer.
- Authorization.
- Filament resources.
- Dashboard.
- Reporting.
- Activity logging.
- Validation.
- Transaction.
- Testing.
- Deployment.

---

# 2. Architectural Decision

Aplikasi menggunakan arsitektur:

```text
Browser
   ↓
Filament Panel
   ↓
Laravel Application
   ├── Filament Resources
   ├── Policies
   ├── Form Requests / Validation
   ├── Services
   ├── Eloquent Models
   └── Activity Logging
   ↓
MySQL
```

Untuk kebutuhan kerja praktik, **tidak perlu microservices**.

Tidak perlu:
- REST API sebagai requirement utama.
- SPA terpisah.
- React/Vue frontend.
- Node.js backend.
- Redis sebagai requirement MVP.
- Queue worker sebagai requirement MVP.

Pendekatan yang dipilih adalah **monolith Laravel + Filament** agar cepat dibuat, mudah dipahami, dan mudah dipresentasikan.

---

# 3. Technology Stack

## 3.1 Required

| Layer | Technology |
|---|---|
| Language | PHP |
| Framework | Laravel |
| Admin Panel | Filament |
| ORM | Laravel Eloquent |
| Database | MySQL |
| Authentication | Laravel + Filament |
| Frontend | Blade + Filament + Livewire |
| Styling | Tailwind CSS melalui Filament |
| Dependency Manager | Composer |
| Frontend Build Tool | Vite |
| Package Manager | npm |
| Version Control | Git |

---

# 4. Version Policy

Gunakan **Laravel dan Filament stable release yang kompatibel satu sama lain pada saat implementasi**.

Jangan mengunci versi major/minor di dokumen ini apabila project baru dibuat setelah dokumen ini disusun.

Saat membuat project, gunakan:

```bash
composer create-project laravel/laravel inventory-app
```

Kemudian pasang Filament sesuai dokumentasi resmi versi stable yang digunakan.

Prinsip:

```text
PHP
  ↓
Laravel stable
  ↓
Filament stable yang compatible
  ↓
MySQL supported version
```

---

# 5. Development Environment

Recommended:

- PHP 8.3+
- Composer 2.x
- Node.js LTS
- npm
- MySQL 8.x
- Git

Local development dapat menggunakan salah satu:

- Laravel Herd.
- Laragon.
- XAMPP.
- Docker.

Untuk mahasiswa, **Laragon atau Laravel Herd** merupakan opsi sederhana.

---

# 6. Project Initialization

Contoh:

```bash
composer create-project laravel/laravel inventory-app

cd inventory-app

php artisan key:generate
```

Konfigurasi database pada `.env`:

```env
APP_NAME="Sistem Inventaris Cabang"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_app
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan:

```bash
php artisan migrate
```

---

# 7. Filament Installation

Install Filament sesuai versi stable yang digunakan.

Setelah instalasi, buat panel:

```bash
php artisan make:filament-panel admin
```

Panel utama:

```text
/admin
```

Panel hanya digunakan untuk internal kantor cabang.

---

# 8. Directory Structure

Struktur yang direkomendasikan:

```text
app/
├── Filament/
│   ├── Resources/
│   │   ├── UserResource/
│   │   ├── CategoryResource/
│   │   ├── RoomResource/
│   │   ├── EmployeeResource/
│   │   ├── ItemResource/
│   │   ├── ItemMutationResource/
│   │   ├── ItemInspectionResource/
│   │   └── ActivityLogResource/
│   │
│   └── Widgets/
│       ├── InventoryStatsWidget.php
│       ├── InventoryConditionChart.php
│       ├── InventoryCategoryChart.php
│       └── RecentActivitiesWidget.php
│
├── Models/
│   ├── User.php
│   ├── Category.php
│   ├── Room.php
│   ├── Employee.php
│   ├── Item.php
│   ├── ItemMutation.php
│   ├── ItemInspection.php
│   └── ActivityLog.php
│
├── Policies/
│   ├── UserPolicy.php
│   ├── CategoryPolicy.php
│   ├── RoomPolicy.php
│   ├── EmployeePolicy.php
│   ├── ItemPolicy.php
│   ├── ItemMutationPolicy.php
│   ├── ItemInspectionPolicy.php
│   └── ActivityLogPolicy.php
│
├── Services/
│   ├── ItemMutationService.php
│   ├── ItemInspectionService.php
│   └── ActivityLogService.php
│
└── Providers/
    └── Filament/
        └── AdminPanelProvider.php

database/
├── factories/
├── migrations/
└── seeders/
    ├── DatabaseSeeder.php
    ├── UserSeeder.php
    ├── CategorySeeder.php
    ├── RoomSeeder.php
    └── EmployeeSeeder.php

resources/
└── views/

routes/
└── web.php

tests/
├── Feature/
└── Unit/
```

---

# 9. Models

Required Eloquent models:

```text
User
Category
Room
Employee
Item
ItemMutation
ItemInspection
ActivityLog
```

---

# 10. Model Relationships

## User

```php
hasMany(ItemMutation::class, 'created_by')
hasMany(ItemInspection::class, 'inspected_by')
hasMany(ActivityLog::class)
```

## Category

```php
hasMany(Item::class)
```

## Room

```php
hasMany(Item::class)

hasMany(ItemMutation::class, 'from_room_id')
hasMany(ItemMutation::class, 'to_room_id')
```

## Employee

```php
hasMany(Item::class)

hasMany(ItemMutation::class, 'from_employee_id')
hasMany(ItemMutation::class, 'to_employee_id')
```

## Item

```php
belongsTo(Category::class)
belongsTo(Room::class)
belongsTo(Employee::class)

hasMany(ItemMutation::class)
hasMany(ItemInspection::class)
```

## ItemMutation

```php
belongsTo(Item::class)

belongsTo(Room::class, 'from_room_id')
belongsTo(Room::class, 'to_room_id')

belongsTo(Employee::class, 'from_employee_id')
belongsTo(Employee::class, 'to_employee_id')

belongsTo(User::class, 'created_by')
```

## ItemInspection

```php
belongsTo(Item::class)
belongsTo(User::class, 'inspected_by')
```

## ActivityLog

```php
belongsTo(User::class)
morphTo('subject')
```

---

# 11. Model Configuration

## Item

Gunakan:

```php
use SoftDeletes;
```

Fillable fields:

```text
inventory_code
serial_number
name
category_id
brand
model
acquisition_year
acquisition_price
room_id
employee_id
condition
status
description
```

Cast:

```text
acquisition_year → integer
acquisition_price → decimal:2
```

---

# 12. Enum Strategy

Untuk MVP, enum dapat menggunakan PHP backed enum agar type-safe.

Recommended:

```text
app/Enums/ItemCondition.php
app/Enums/ItemStatus.php
app/Enums/MutationType.php
app/Enums/UserRole.php
```

## ItemCondition

```php
enum ItemCondition: string
{
    case BAIK = 'baik';
    case RUSAK_RINGAN = 'rusak_ringan';
    case RUSAK_BERAT = 'rusak_berat';
    case HILANG = 'hilang';
}
```

## ItemStatus

```php
enum ItemStatus: string
{
    case AKTIF = 'aktif';
    case TIDAK_AKTIF = 'tidak_aktif';
    case DALAM_PERBAIKAN = 'dalam_perbaikan';
}
```

## MutationType

```php
enum MutationType: string
{
    case ROOM = 'room';
    case RESPONSIBLE_EMPLOYEE = 'responsible_employee';
    case ROOM_AND_EMPLOYEE = 'room_and_employee';
}
```

## UserRole

```php
enum UserRole: string
{
    case ADMIN = 'admin';
    case PETUGAS = 'petugas';
}
```

---

# 13. Database Migration

Migration harus mengikuti dependency:

```text
users
  ↓
categories
  ↓
rooms
  ↓
employees
  ↓
items
  ↓
item_mutations
item_inspections
activity_logs
```

Foreign key harus menggunakan constraint database.

Contoh:

```php
$table->foreignId('category_id')
    ->constrained()
    ->restrictOnDelete();
```

Untuk room:

```php
$table->foreignId('room_id')
    ->nullable()
    ->constrained()
    ->nullOnDelete();
```

Untuk employee:

```php
$table->foreignId('employee_id')
    ->nullable()
    ->constrained()
    ->nullOnDelete();
```

---

# 14. Migration Rules

## users

- `email` unique.
- `role` indexed.
- `is_active` indexed.

## categories

- `name` unique.

## rooms

- `code` unique.
- `name` indexed.
- `is_active` indexed.

## employees

- `employee_number` nullable unique.
- `name` indexed.
- `is_active` indexed.

## items

- `inventory_code` unique.
- `serial_number` indexed.
- `name` indexed.
- FK fields indexed.
- `condition` indexed.
- `status` indexed.
- `acquisition_year` indexed.
- soft deletes.

## item_mutations

Semua foreign key dan `mutation_date` harus indexed.

## item_inspections

`item_id`, `inspection_date`, `condition`, `is_found`, dan `inspected_by` indexed.

## activity_logs

`user_id`, `action`, `subject_type`, `subject_id`, dan `created_at` indexed.

---

# 15. Filament Resources

Required Resources:

```text
UserResource
CategoryResource
RoomResource
EmployeeResource
ItemResource
ItemMutationResource
ItemInspectionResource
ActivityLogResource
```

---

# 16. Navigation Structure

Recommended:

```text
Dashboard

MASTER DATA
├── Kategori Barang
├── Ruangan
└── Pegawai

INVENTARIS
├── Barang
├── Mutasi Barang
└── Pemeriksaan Barang

LAPORAN
├── Laporan Inventaris
├── Laporan Mutasi
└── Laporan Pemeriksaan

SISTEM
├── Pengguna
└── Activity Log
```

---

# 17. ItemResource

## Form Sections

### Informasi Barang

Fields:
- `inventory_code`
- `name`
- `category_id`
- `serial_number`
- `brand`
- `model`

### Perolehan

Fields:
- `acquisition_year`
- `acquisition_price`

### Penempatan

Fields:
- `room_id`
- `employee_id`

### Status

Fields:
- `condition`
- `status`

### Deskripsi

Field:
- `description`

---

# 18. ItemResource Table

Columns:

```text
inventory_code
name
category.name
brand
model
room.name
employee.name
condition
status
acquisition_year
```

Filters:

```text
category_id
room_id
employee_id
condition
status
acquisition_year
```

Search:

```text
inventory_code
name
serial_number
brand
model
```

Actions:

```text
View
Edit
Delete
```

Additional actions:

```text
Mutasi
Pemeriksaan
```

---

# 19. CategoryResource

Form:

```text
name
description
```

Table:

```text
name
items_count
created_at
```

Actions:

```text
Edit
```

Delete hanya boleh dilakukan jika tidak digunakan.

---

# 20. RoomResource

Form:

```text
code
name
description
is_active
```

Table:

```text
code
name
items_count
is_active
```

Room sebaiknya dinonaktifkan daripada dihapus.

---

# 21. EmployeeResource

Form:

```text
name
employee_number
position
department
is_active
```

Table:

```text
name
employee_number
position
department
items_count
is_active
```

Employee sebaiknya dinonaktifkan daripada dihapus.

---

# 22. UserResource

Hanya admin.

Form:

```text
name
email
password
role
is_active
```

Password:
- Required saat create.
- Optional saat edit.
- Hash sebelum disimpan.

Table:

```text
name
email
role
is_active
created_at
```

Petugas tidak dapat mengakses resource ini.

---

# 23. ItemMutationResource

Historical resource.

Default:
- Read-only.

Table:

```text
mutation_date
item.inventory_code
item.name
mutation_type
fromRoom.name
toRoom.name
fromEmployee.name
toEmployee.name
creator.name
```

Tidak menyediakan:
- Edit.
- Delete.

Mutation dilakukan melalui custom action/form dari ItemResource atau halaman khusus.

---

# 24. Mutation Form

Fields:

```text
item_id
mutation_type
to_room_id
to_employee_id
mutation_date
description
```

Current state ditampilkan sebagai informasi read-only:

```text
Current Room
Current Responsible Employee
```

Rules berdasarkan mutation type:

### room

Wajib:
- `to_room_id`

Tidak perlu:
- `to_employee_id`

### responsible_employee

Wajib:
- `to_employee_id`

Tidak perlu:
- `to_room_id`

### room_and_employee

Wajib:
- `to_room_id`
- `to_employee_id`

---

# 25. ItemMutationService

Business logic mutation **tidak boleh ditempatkan seluruhnya di Filament Resource**.

Gunakan:

```text
app/Services/ItemMutationService.php
```

Method utama:

```php
public function mutate(
    Item $item,
    MutationType $type,
    ?int $toRoomId,
    ?int $toEmployeeId,
    CarbonInterface $mutationDate,
    ?string $description,
    User $user
): ItemMutation
```

Flow:

```text
DB::transaction()

↓
lock item

↓
capture current state

↓
create mutation history

↓
update current state

↓
create activity log

↓
commit
```

Gunakan:

```php
$item = Item::query()
    ->lockForUpdate()
    ->findOrFail($item->id);
```

---

# 26. Mutation Validation

Validation harus memastikan:

## room

```text
to_room_id required
```

## responsible_employee

```text
to_employee_id required
```

## room_and_employee

```text
to_room_id required
to_employee_id required
```

Destination tidak boleh sama dengan current state jika mutation tersebut tidak menghasilkan perubahan.

Contoh:

```text
Current room = A
Target room  = A
```

Maka mutation tidak valid jika tidak ada perubahan lain.

---

# 27. ItemInspectionResource

Historical resource.

Table:

```text
inspection_date
item.inventory_code
item.name
is_found
condition
inspector.name
```

Tidak menyediakan:
- Edit.
- Delete.

Pemeriksaan dilakukan melalui action/form.

---

# 28. Inspection Form

Fields:

```text
item_id
inspection_date
is_found
condition
notes
```

Jika:

```text
is_found = false
```

maka:

```text
condition = hilang
```

Field condition dapat otomatis diisi dan dibuat disabled.

Jika:

```text
is_found = true
```

maka condition wajib dipilih.

---

# 29. ItemInspectionService

Gunakan:

```text
app/Services/ItemInspectionService.php
```

Method:

```php
public function inspect(
    Item $item,
    CarbonInterface $inspectionDate,
    bool $isFound,
    ItemCondition $condition,
    ?string $notes,
    User $user
): ItemInspection
```

Flow:

```text
DB::transaction()

↓
lock item

↓
create inspection

↓
update item.condition

↓
create activity log

↓
commit
```

Jika barang tidak ditemukan:

```text
condition = hilang
```

---

# 30. Authorization

Gunakan Laravel Policy.

Required policies:

```text
UserPolicy
CategoryPolicy
RoomPolicy
EmployeePolicy
ItemPolicy
ItemMutationPolicy
ItemInspectionPolicy
ActivityLogPolicy
```

---

# 31. Authorization Matrix

| Action | Admin | Petugas |
|---|---:|---:|
| View Dashboard | Yes | Yes |
| View Items | Yes | Yes |
| Create Item | Yes | Yes |
| Update Item | Yes | Yes |
| Delete Item | Yes | Yes |
| View Categories | Yes | Yes |
| Manage Categories | Yes | Yes |
| View Rooms | Yes | Yes |
| Manage Rooms | Yes | Yes |
| View Employees | Yes | Yes |
| Manage Employees | Yes | Yes |
| Create Mutation | Yes | Yes |
| View Mutation History | Yes | Yes |
| Delete Mutation | No | No |
| Create Inspection | Yes | Yes |
| View Inspection History | Yes | Yes |
| Delete Inspection | No | No |
| View Reports | Yes | Yes |
| Manage Users | Yes | No |
| View Activity Logs | Yes | No |
| Delete Activity Logs | No | No |

---

# 32. Authentication

Filament menangani authentication panel.

Requirements:
- Login.
- Logout.
- Session.
- Password hashing.
- Authorization.

User inactive:

```php
is_active = false
```

tidak boleh login.

Implementasikan melalui Filament authentication/panel authorization.

---

# 33. Activity Logging

Gunakan service:

```text
app/Services/ActivityLogService.php
```

Method:

```php
public function log(
    ?User $user,
    string $action,
    ?Model $subject,
    ?string $description = null
): ActivityLog
```

Data:
- user.
- action.
- subject_type.
- subject_id.
- description.
- ip_address.
- created_at.

IP address:

```php
request()->ip()
```

---

# 34. Activity Log Trigger

Minimal trigger:

```text
CREATE_ITEM
UPDATE_ITEM
DELETE_ITEM
CREATE_MUTATION
CREATE_INSPECTION
CREATE_USER
UPDATE_USER
```

Activity log untuk mutation dan inspection harus dibuat dalam transaction yang sama.

---

# 35. Dashboard

Filament Dashboard terdiri dari widgets.

## Widget 1 — Inventory Stats

Cards:

```text
Total Barang
Barang Aktif
Tidak Aktif
Dalam Perbaikan
Baik
Rusak Ringan
Rusak Berat
Hilang
```

## Widget 2 — Condition Chart

Chart:

```text
Baik
Rusak Ringan
Rusak Berat
Hilang
```

## Widget 3 — Category Chart

Menampilkan jumlah barang per kategori.

## Widget 4 — Recent Activity

Menampilkan aktivitas terbaru.

---

# 36. Reporting

Untuk MVP, laporan dapat dibuat sebagai Filament pages atau table pages.

## Inventory Report

Filter:

```text
category
room
condition
status
year
```

Columns:

```text
inventory_code
name
category
brand
model
room
employee
condition
status
acquisition_year
```

---

# 37. Export

Export adalah optional MVP enhancement.

Jika diimplementasikan:
- CSV.
- XLSX.
- PDF.

Prioritas:

```text
CSV → XLSX → PDF
```

Jangan membuat export menjadi blocker untuk MVP.

---

# 38. Validation Rules

## Item

```text
inventory_code:
required|string|max:100|unique:items,inventory_code

name:
required|string|max:255

category_id:
required|exists:categories,id

serial_number:
nullable|string|max:255

brand:
nullable|string|max:255

model:
nullable|string|max:255

acquisition_year:
nullable|integer

acquisition_price:
nullable|numeric|min:0

room_id:
nullable|exists:rooms,id

employee_id:
nullable|exists:employees,id

condition:
required|in:baik,rusak_ringan,rusak_berat,hilang

status:
required|in:aktif,tidak_aktif,dalam_perbaikan
```

Unique inventory code saat update harus mengabaikan record saat ini.

---

# 39. Validation Master Data

## Category

```text
name:
required|string|max:255|unique:categories,name
```

## Room

```text
code:
required|string|max:50|unique:rooms,code

name:
required|string|max:255
```

## Employee

```text
name:
required|string|max:255

employee_number:
nullable|string|max:100|unique:employees,employee_number

position:
required|string|max:255

department:
nullable|string|max:255
```

---

# 40. Soft Delete

Hanya `items` yang menggunakan SoftDeletes pada MVP.

```php
use Illuminate\Database\Eloquent\SoftDeletes;
```

Jangan soft-delete historical records.

Historical records harus tetap ada.

---

# 41. Transaction Policy

Transaction wajib untuk:

```text
Create Mutation
Create Inspection
```

Transaction tidak wajib untuk CRUD sederhana.

Contoh:

```php
DB::transaction(function () {
    // mutation
});
```

Jika salah satu proses gagal:

```text
ROLLBACK
```

---

# 42. Concurrency

Mutation dan inspection harus menggunakan row lock terhadap item:

```php
lockForUpdate()
```

Tujuannya mencegah dua petugas melakukan perubahan current state secara bersamaan dan menghasilkan histori yang tidak konsisten.

---

# 43. Eager Loading

Hindari N+1 query pada Filament table.

Contoh:

```php
Item::query()
    ->with([
        'category',
        'room',
        'employee',
    ]);
```

Untuk mutation:

```php
ItemMutation::query()
    ->with([
        'item',
        'fromRoom',
        'toRoom',
        'fromEmployee',
        'toEmployee',
        'creator',
    ]);
```

---

# 44. Query & Filter

Gunakan database filtering, bukan memuat seluruh data ke PHP.

Contoh:

```text
where
whereHas
relationship filters
pagination
```

Jangan:
- mengambil seluruh item,
- lalu filtering menggunakan collection PHP.

---

# 45. Pagination

Default table pagination:

```text
10 / 25 / 50 / 100
```

Default:

```text
25
```

---

# 46. Seed Data

Seeder minimal:

## Users

```text
Admin
Petugas
```

## Categories

Contoh:

```text
Komputer
Laptop
Printer
Scanner
Monitor
Furniture
Peralatan Jaringan
Peralatan Elektronik
Peralatan Kantor
```

## Rooms

Contoh:

```text
Ruang Kepala
Ruang Pelayanan
Ruang Administrasi
Ruang Arsip
Ruang Server
Gudang
```

## Employees

Gunakan data dummy.

Jangan memasukkan data pegawai asli ke repository Git.

---

# 47. Factory

Recommended factories:

```text
UserFactory
CategoryFactory
RoomFactory
EmployeeFactory
ItemFactory
ItemMutationFactory
ItemInspectionFactory
ActivityLogFactory
```

Factories digunakan untuk testing.

---

# 48. Testing Strategy

Minimum:

```text
Unit Tests
Feature Tests
```

---

# 49. Unit Tests

Test:

```text
ItemMutationService
ItemInspectionService
ActivityLogService
```

Contoh:

```text
mutation room updates item room
mutation employee updates item employee
mutation both updates both
inspection found updates condition
inspection not found sets condition to hilang
transaction rollback on failure
```

---

# 50. Feature Tests

Test:

## Authentication

```text
active user can login
inactive user cannot login
```

## Authorization

```text
petugas cannot manage users
petugas cannot view activity logs
```

## Inventory

```text
can create item
inventory code must be unique
can update item
can soft delete item
```

## Mutation

```text
can create mutation
mutation history is created
current state is updated
```

## Inspection

```text
can create inspection
inspection history is created
condition is updated
```

---

# 51. Example Mutation Test Cases

### Case 1

Initial:

```text
Room = A
Employee = B
```

Mutation:

```text
type = room
to_room = C
```

Expected:

```text
Item.room = C
Item.employee = B

Mutation.from_room = A
Mutation.to_room = C
```

### Case 2

Initial:

```text
Room = A
Employee = B
```

Mutation:

```text
type = responsible_employee
to_employee = C
```

Expected:

```text
Item.room = A
Item.employee = C
```

### Case 3

Initial:

```text
Room = A
Employee = B
```

Mutation:

```text
type = room_and_employee
to_room = C
to_employee = D
```

Expected:

```text
Item.room = C
Item.employee = D
```

---

# 52. Example Inspection Test Cases

### Found + Good

```text
is_found = true
condition = baik
```

Expected:

```text
item.condition = baik
```

### Found + Damaged

```text
is_found = true
condition = rusak_ringan
```

Expected:

```text
item.condition = rusak_ringan
```

### Not Found

```text
is_found = false
```

Expected:

```text
item.condition = hilang
```

---

# 53. Error Handling

User-facing errors harus sederhana.

Contoh:

```text
"Data barang gagal disimpan."
"Mutasi barang gagal diproses."
"Pemeriksaan barang gagal disimpan."
```

Detail exception tidak ditampilkan kepada user pada production.

Exception harus masuk ke Laravel logging.

---

# 54. Logging

Gunakan Laravel Log.

Production:

```env
APP_ENV=production
APP_DEBUG=false
LOG_CHANNEL=stack
```

Jangan menampilkan stack trace kepada pengguna.

---

# 55. Security

Minimum:

- Password hashing.
- CSRF protection.
- Authorization.
- Server-side validation.
- Mass assignment protection.
- Database foreign key.
- Production `APP_DEBUG=false`.
- HTTPS pada production.
- Session security.
- Jangan commit `.env`.

---

# 56. Environment Variables

Minimal:

```env
APP_NAME=
APP_ENV=
APP_KEY=
APP_DEBUG=
APP_URL=

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

`.env` wajib masuk `.gitignore`.

Repository hanya menyimpan:

```text
.env.example
```

---

# 57. Git Workflow

Recommended:

```text
main
└── develop
    ├── feature/auth
    ├── feature/inventory
    ├── feature/mutation
    ├── feature/inspection
    └── feature/report
```

Untuk kerja praktik sederhana, minimal:

```text
main
└── feature/*
```

Commit harus deskriptif.

Contoh:

```text
feat: add item resource
feat: add mutation service
feat: add inspection workflow
fix: prevent duplicate inventory code
test: add mutation service tests
```

---

# 58. Deployment

Target deployment:

```text
Web Server
├── Nginx / Apache
├── PHP
├── MySQL
└── Laravel
```

Document root harus:

```text
/public
```

Jangan mengarahkan web server ke root project.

---

# 59. Production Commands

Contoh:

```bash
composer install --no-dev --optimize-autoloader

php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Jika Filament membutuhkan asset build:

```bash
npm ci
npm run build
```

---

# 60. Production Environment

```env
APP_ENV=production
APP_DEBUG=false
```

Gunakan:
- HTTPS.
- Database backup.
- Strong database credentials.
- Strong application secret.

---

# 61. Backup

Minimum:
- Backup database secara berkala.
- Simpan backup di lokasi terpisah dari server aplikasi.
- Uji restore secara berkala.

Backup bukan fitur aplikasi MVP, tetapi merupakan operational requirement production.

---

# 62. Data Privacy

Karena sistem digunakan pada kantor pemerintahan:

- Jangan memasukkan data pribadi nyata ke Git repository.
- Gunakan data dummy untuk development.
- Batasi akses user.
- Jangan menampilkan password.
- Activity log tidak boleh dapat diedit oleh user biasa.

---

# 63. Performance Baseline

Target MVP:

- Pagination pada semua tabel.
- Index untuk kolom pencarian/filter.
- Eager loading relationship.
- Hindari N+1.
- Hindari query seluruh tabel untuk dashboard jika tidak diperlukan.

Untuk skala satu kantor cabang, MySQL + Laravel cukup.

Tidak perlu Elasticsearch untuk MVP.

---

# 64. Recommended Implementation Order

Implementasi sebaiknya mengikuti urutan:

```text
1. Project setup
2. Database migrations
3. Models + relationships
4. Enums
5. Seeders + factories
6. Authentication
7. Policies
8. Master data resources
9. Item resource
10. Activity logging
11. Mutation service + resource
12. Inspection service + resource
13. Dashboard
14. Reports
15. Testing
16. UI polish
17. Deployment
```

---

# 65. Definition of Done — Technical

Project siap demo apabila:

- [ ] Laravel berjalan.
- [ ] Filament panel berjalan.
- [ ] MySQL terhubung.
- [ ] Semua migration berhasil.
- [ ] Semua model tersedia.
- [ ] Relationship tersedia.
- [ ] Seeder berjalan.
- [ ] Admin dapat login.
- [ ] Petugas dapat login.
- [ ] Authorization berjalan.
- [ ] CRUD kategori berjalan.
- [ ] CRUD ruangan berjalan.
- [ ] CRUD pegawai berjalan.
- [ ] CRUD barang berjalan.
- [ ] Search/filter barang berjalan.
- [ ] Mutation berjalan dengan transaction.
- [ ] Inspection berjalan dengan transaction.
- [ ] Activity log berjalan.
- [ ] Dashboard berjalan.
- [ ] Report inventaris berjalan.
- [ ] Report mutation berjalan.
- [ ] Report inspection berjalan.
- [ ] Historical data read-only.
- [ ] Soft delete item berjalan.
- [ ] Feature test utama lulus.
- [ ] Production debug dimatikan.

---

# 66. AI Coding Rules

Jika dokumen ini diberikan kepada AI coding agent, agent harus mengikuti aturan berikut.

## Rule 1 — Scope

Aplikasi adalah:

```text
SATU KANTOR CABANG DISDUKCAPIL
```

Jangan membuat:
- multi-tenant.
- branch management.
- office management.
- headquarters management.

## Rule 2 — Architecture

Gunakan:

```text
Laravel
+
Filament
+
Eloquent
+
MySQL
```

Jangan menambahkan framework frontend terpisah tanpa requirement.

## Rule 3 — Business Logic

Business logic mutation dan inspection wajib berada di service.

Jangan menaruh seluruh business logic di Filament Resource.

## Rule 4 — Transactions

Mutation dan inspection wajib menggunakan database transaction.

## Rule 5 — Historical Data

Jangan menyediakan edit/delete normal untuk:

```text
item_mutations
item_inspections
activity_logs
```

## Rule 6 — Current State

Current state barang berada pada:

```text
items.room_id
items.employee_id
items.condition
items.status
```

## Rule 7 — History

History berada pada:

```text
item_mutations
item_inspections
```

## Rule 8 — Authorization

Selalu gunakan policy/authorization.

Jangan hanya menyembunyikan tombol UI.

## Rule 9 — Database

Gunakan foreign keys dan indexes sesuai ERD.

## Rule 10 — Simplicity

Prioritaskan implementasi sederhana yang mudah dipahami mahasiswa.

Jangan over-engineering.

---

# 67. Source of Truth

Jika terjadi konflik:

```text
PRD.md
   ↓
ERD.md
   ↓
TECH_SPEC.md
```

Business requirement berasal dari `PRD.md`.

Struktur database berasal dari `ERD.md`.

Implementasi teknis mengikuti `TECH_SPEC.md`.

Jika ada requirement baru yang mengubah business process atau schema, update ketiga dokumen sebelum implementasi besar dilakukan.

---

# 68. Final Technology Architecture

```text
                    ┌─────────────────────┐
                    │       Browser       │
                    └──────────┬──────────┘
                               │
                               ▼
                    ┌─────────────────────┐
                    │  Filament Admin UI  │
                    │ Blade + Livewire     │
                    └──────────┬──────────┘
                               │
                               ▼
                    ┌─────────────────────┐
                    │       Laravel       │
                    │                     │
                    │ Policies            │
                    │ Resources           │
                    │ Services            │
                    │ Eloquent Models     │
                    │ Validation          │
                    │ Activity Logging    │
                    └──────────┬──────────┘
                               │
                               ▼
                    ┌─────────────────────┐
                    │        MySQL        │
                    │                     │
                    │ users               │
                    │ categories          │
                    │ rooms               │
                    │ employees           │
                    │ items               │
                    │ item_mutations      │
                    │ item_inspections    │
                    │ activity_logs       │
                    └─────────────────────┘
```

---

# 69. Final Stack

```text
PHP
 ↓
Laravel
 ↓
Filament
 ↓
Livewire / Blade
 ↓
Eloquent ORM
 ↓
MySQL
```

Architecture:

```text
Monolithic
Server-rendered
Admin-focused
Transaction-safe
Role-based
```

Target:

```text
Simple
Fast
Maintainable
Easy to deploy
Easy to explain for Kerja Praktik
```
