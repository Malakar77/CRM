<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('table_comment_type', function (Blueprint $table) {
            $table->id();
            $table->integer("id_check")->nullable();
            $table->string("type", 255)->nullable();
            $table->text("text")->nullable();
            $table->string("status", 255)->nullable();
            $table->timestamps();
        });

        DB::table('table_comment_type')->insert([
            'id_check' => 1,
            'type' => 'comment',
            'text' => '
                1. Счет действителен в течение 3-х банковских дней. По истечени указанного срока,
                Поставщик не гарантирует наличие Товара и его заявленную стоимость. &lt;br&gt;
                2. При оплате не действительного счета Покупателем, Поставщик засчитывает
                поступившие денежные средства в счет будущих поставок, если от Покупателя
                не поступят письменные требования о возврате, в этом случае Поставщик
                возвращает денежные средства в течение 30 дней со дня поступления письменного требования. &lt;br&gt;
                3. Погрузка готовой продукции производится только в открытый автотранспорт. При погрузке
                в крытую машину взимается дополнительная плата. &lt;br&gt;
                4. Поставка товара осуществляется на условиях выборки(самовывоза) товара со склада Поставщика,
                если только Покупатель не оплатит Поставщику его поставку через транспортную организацию.
                Отгрузка на складе производится по фактическому весу,
                вес в счете указан по теории - справочные величины. &lt;br&gt;
                5. Моментом перехода права собственности является момент получения товара наскладе Поставщика
                Покупателем, уполномоченным им грузополучателем либо грузоперевозчиком при оплате Покупателем
                доставки товара. &lt;br&gt;
                6. Товар должен быть вывезен со склада в течение 5ти рабочих дней с момента поступления денег
                на расчетный счет Поставщика. В случае задержки вывоза, Покупатель оплачивает услуги за
                хранение в размере 1% от стоимости товара за каждый день.
                При этом Поставщик в праве реализовать Товар на 20й день задержки. &lt;br&gt;
                7. Приемка продукции Покупателем производится согласно Инструкции №П-6 и №П-7 &quot;
                О порядке приемки продукции производственно-технического назначения товаров народного
                потребления по количеству и качеству&quot;, утвержденным Постановлением Госарбитража СССР.
                При обнаружении недостатков по качеству и комплектности, вызов представителя
                Поставщика обязателен. &lt;br&gt;
                8. Допускается незначительная шероховатость, забоины, вмятины, мелкие риски,
                тонкий слой окалины. &lt;br&gt;
                9. В случае возникновения разногласий, споры подлежат разрешению в арбитражном суде по месту
                нахождения Поставщика. Срок рассмотрения претензии - 10 дней. &lt;br&gt;
                10. Металлопрокат, прошедший резку или обработку, возврату и обмену не подлежит. &lt;br&gt;
                11. Оплата счет означает согласие с условиями поставки товара. &lt;br&gt;
                12. Толеранс на поставку продукции составляет +-10%
            ',
            'status' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_comment_type');
    }
};
