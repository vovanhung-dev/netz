// database/migrations/2025_01_01_000000_create_careers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('position', 191);
            $table->unsignedInteger('number')->default(1);
            $table->date('expiration_date');
            $table->longText('description')->nullable();
            $table->boolean('is_open')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Indexes cho lọc/sort phổ biến
            $table->index(['is_open', 'expiration_date']);       // lọc theo trạng thái + hạn
            $table->index('expiration_date');

            // Nếu dùng MySQL 8+ ⇒ bật FULLTEXT để search theo position/description
            // $table->fullText(['position', 'description']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
