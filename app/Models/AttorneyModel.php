<?php

namespace App\Models;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;

class AttorneyModel extends Model
{
    use HasFactory;

    protected $table = 'attorney';

    /**
     * Получение данных о доверенности
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function getAttorney(int $id)
    {
        return self::query()->where('id', UtilityHelper::get_variable($id))->first();
    }

    /**
     * Получение данных о логисте
     * @param int $id
     * @return Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function getByLogist(int $id)
    {
        return DB::table('logistics')->where('id', UtilityHelper::get_variable($id))->first();
    }

    /**
     * Получение данных о компании
     * @param int $id
     * @return Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function getByCompany(int $id)
    {
        return DB::table('company')->where('id', UtilityHelper::get_variable($id))->first();
    }

    /**
     * Метод добавления компании
     * @param object $data
     * @return false|int
     */
    public static function addCompany( object $data)
    {

        $result = DB::table('company')->insertGetId([

            'type' => UtilityHelper::get_variable($data->status),
            'company_name' => UtilityHelper::get_variable($data->nameCompanySearch),
            'inn_company' => UtilityHelper::get_variable($data->innCompanySearch),
            'kpp_company' => UtilityHelper::get_variable($data->kppCompanySearch),
            'ur_address_company' => UtilityHelper::get_variable($data->adCompanySearch),
            'address_company' => UtilityHelper::get_variable($data->urCompanySearch),
            'bank' => UtilityHelper::get_variable($data->bank),
            'bik_bank_company' => UtilityHelper::get_variable($data->bikBankCompany),
            'kor_chet' => UtilityHelper::get_variable($data->korChet),
            'ras_chet' => UtilityHelper::get_variable($data->rasChet),
            'user' => Auth::user()->id,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return $result ?: false;
    }

    /**
     * Получение данных о компании закрепленных за менеджером
     * @return \Illuminate\Support\Collection
     */
    public static function getCompany(): \Illuminate\Support\Collection
    {
        return DB::table('company')->select('id', 'type', 'company_name', 'user')
                ->where('type', 'dover')
                ->where('user', Auth::user ()->id)
                ->get();
    }

    /**
     * Метод получения о редактируемой компании
     * @param int $data id редактируемой компании
     * @return \Illuminate\Support\Collection Возвращает послную информацию о компании
     */
    public static function getDataCompany( int $data)
    {
        return DB::table('company')->where('id', UtilityHelper::get_variable($data))->get();
    }

    public static function getDataLogist( int $data)
    {
        return DB::table('logistics')->where('id', UtilityHelper::get_variable($data))->get();
    }
    /**
     * Метод обновления информации о компании
     * @param object $data данные из формы
     * @return false|int возвращает
     */
    public static function updateCompany( object $data)
    {
        $result = DB::table('company')
            ->where('id', UtilityHelper::get_variable($data->id))
            ->update([
                'company_name' => UtilityHelper::get_variable($data->nameCompanyEdit),
                'inn_company' => UtilityHelper::get_variable($data->innCompanyEdit),
                'kpp_company' => UtilityHelper::get_variable($data->kppCompanyEdit),
                'ur_address_company' => UtilityHelper::get_variable($data->adCompanyEdit),
                'address_company' => UtilityHelper::get_variable($data->urCompanyEdit),
                'bank' => UtilityHelper::get_variable($data->bankEdit),
                'bik_bank_company' => UtilityHelper::get_variable($data->bikBankEdit),
                'kor_chet' => UtilityHelper::get_variable($data->korChetEdit),
                'ras_chet' => UtilityHelper::get_variable($data->rasChetEdit),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        return $result ?: false;
    }

    /**
     * Метод получения всех данных о доверенностях
     * @return false|\Illuminate\Support\Collection
     */
    public static function getAttorneyUser(): bool|\Illuminate\Support\Collection
    {
        $result = DB::table('attorney')
            ->where ('id_manager', Auth::user ()->id)
            ->where ('status', true)
            ->get();
        return $result ?: false;
    }

    public static function deleteAttorneyUser(int $id): bool|int
    {
        $result = DB::table('attorney')
            ->where('id', UtilityHelper::get_variable($id))
            ->update([
                'status' => false,
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        return $result ?: false;
    }

    public static function emptyVal( $str)
    {
        if(isset($str)) {

            return !empty( $str ) ? $str : null;
        }
        return null;
    }


    public static function printFile($data)
    {


        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'portrait');


        $logistic     = (object)$data->logist;
        $provider     = (object)$data->providerCompany;

        $info = (object) [];
        $info->numder = self::emptyVal($data->numberDov);
        $info->date_do['full'] = '';
        $info->date_do['y'] = '';
        $info->date_do['d'] = '';
        $info->date_do['m'] = '';
        $info->info = self::emptyVal($data->info);
        $info->date_ot['full'] = '';
        $info->date_ot['y'] = '';
        $info->date_ot['d'] = '';
        $info->date_ot['m'] = '';
        $info->name = '';
        $info->nameProvider='';
        $info->nameCompany ='';
        $info->fullname = '';
        $info->numberChet = '';
        $info->fullNameLogist = '';
        $info->document = '';
        $info->series = '';
        $info->numberDoc = '';
        $info->documentDate = '';
        $info->issued ='';

        if (isset($data['date_ot'])) {
            if (!empty($data['date_ot'])) {
                $res = UtilityHelper::formatDate($data['date_ot']);
                $info->date_ot['full'] = $res['full'];
                $info->date_ot['y'] = $res['y'];
                $info->date_ot['d'] = $res['d'];
                $info->date_ot['m'] = $res['m'];
            } else {
                // Если данных нет, явно создаем массив с ключом 'full'
                $info->date_ot['full'] = '';

            }
        }

        if (isset($data['date_do'])) {
            if (!empty($data['date_do'])) {
                $res = UtilityHelper::formatDate($data['date_do']);
                $info->date_do['full'] = $res['full'];
                $info->date_do['y'] = $res['y'];
                $info->date_do['d'] = $res['d'];
                $info->date_do['m'] = $res['m'];
            } else {
                // Если данных нет, явно создаем массив с ключом 'full'
                $info->date_do['full'] = '';
            }
        }


        if(isset($logistic->surname)){
            $info->name = !empty($logistic->surname) ? $logistic->surname . ' ' : '';
        }

        if(isset($logistic->name)){
            $info->name .= !empty($logistic->name) ? mb_substr($logistic->name,0,1) . '. ' : '' ;
        }

        if(isset($logistic->patronymic)){
            $info->name .= !empty($logistic->patronymic) ? mb_substr($logistic->patronymic,0,1) . '. ' : '';
        }

        if(isset($provider->company_name)){
            $info->nameProvider = self::emptyVal($provider->company_name);
        }

        if(isset($data["company"]['company_name'])){
            $info->nameCompany = self::emptyVal($data["company"]['company_name']) . ' ';
        }

        if(isset($data["company"]['company_name'])){
            $info -> fullname .= !empty($data["company"]['company_name']) ? $data["company"]['company_name'] : '';
        }

        if(isset($data["company"]['inn_company'])) {
            $info -> fullname .= !empty($data[ "company" ][ 'inn_company' ]) ? 'ИНН: ' . $data[ "company" ][ 'inn_company' ] . ', ' : '';
        }

        if(isset($data["company"]['kpp_company'])) {
            $info -> fullname .= !empty($data[ "company" ][ 'kpp_company' ]) ? 'КПП: ' . $data[ "company" ][ 'kpp_company' ] . ', ' : '';
        }

        if(isset($data["company"]['ur_address_company'])) {
            $info -> fullname .= !empty($data[ "company" ][ 'ur_address_company' ]) ? $data[ "company" ][ 'ur_address_company' ] : '';
        }

        if(isset($data["company"]['ras_chet'])) {
            $info -> numberChet = !empty($data[ "company" ][ 'ras_chet' ]) ? $data[ "company" ][ 'ras_chet' ].', в ' : '';
        }

        if(isset($data["company"]['bank'])) {
            $info -> numberChet .= !empty($data[ "company" ][ 'bank' ]) ? $data[ "company" ][ 'bank' ].', ' : '';
        }

        if(isset($data["company"]['bik_bank_company'])) {
            $info -> numberChet .= !empty($data[ "company" ][ 'bik_bank_company' ]) ? 'БИК: '.$data[ "company" ][ 'bik_bank_company' ].', ' : '';
        }

        if(isset($data["company"]['kor_chet'])) {
            $info -> numberChet .= !empty($data[ "company" ][ 'kor_chet' ]) ? 'k/c '.$data[ "company" ][ 'kor_chet' ] : ' ';
        }

        if(isset($data["logist"]['surname']) && isset($data["logist"]['name']) && isset($data["logist"]['patronymic'])) {

            $info -> fullNameLogist = $data["logist"]['surname'] . ' ' . $data["logist"]['name'] . ' ' . $data["logist"]['patronymic'];
        }

        if(isset($data["logist"]['document'])) {

            $info->document = !empty($data["logist"]['document']) ? $data["logist"]['document'] : ' ';
        }

        if(isset($data["logist"]['series'])) {
            $info->series = !empty($data["logist"]['series']) ? $data["logist"]['series'] : ' ';
        }

        if(isset($data["logist"]['number'])) {

            $info->numberDoc = !empty($data["logist"]['number']) ? $data["logist"]['number'] : ' ';
        }

        if(isset($data["logist"]['date_issued'])) {

            $info->documentDate =  !empty($data["logist"]['date_issued']) ? UtilityHelper::formatDate ($data["logist"]['date_issued']) : ' ';
        }



        if(isset($data["logist"]['issued'])) {
            $info -> issued	 = !empty($data[ "logist" ][ 'issued' ]) ? $data[ "logist" ][ 'issued' ] : ' ';
        }


        $html = /* @lang HTML */'

    <!doctype html>
        <html>
            <head>
    <style>
        body{
        margin: 0;
            font-size: 9px;
            font-family: "DejaVu Sans", sans-serif;

        }

        table{
            border: 1px solid #0f0f0f;
            border-collapse: collapse;

        }

        thead:nth-child(1n){
            height: 50px !important;
        }

        tbody:nth-child(1n){
            height: 10px;
        }

        tbody:nth-child(1n){
            height: auto;
            padding: 5px;
        }

        th{
            font-size: 8px;
        }

        th,td{
            border: 1px solid #0f0f0f;
            text-align: center;
        }

        .line{
            margin-top: 10px;
            height: 20px;
            border-bottom: 1px solid #000000;
            width: 100%;
        }

        .line:before{
            content: \'Линия отреза\';
            display: block;
            text-align: center;
        }

        .containerInfo{
            width: 100%;
            height: 49px;
            margin-top: 10px;

        }

        .rowInfo{
            width: 50%;
            height: 100%;
            margin-left: auto;


        }

        .oneInfo{
            width: 100%;
            text-align: right;
            display: block;
        }

        .twoInfo{
        width: 100%;
        text-align: right;
        display: block;
        }

        .treeInfo{
            width: 100%;
            text-align: right;
            display: block;
        }

        .containerCode{

            height: 55px;
        }

        .colCodeOne{
            width: 50px;
            border: 1px solid #000000;
            text-align: center;
            margin-left: auto;
        }

        .colCodeTwo {
            display: block;
            width: 30%;
            margin-left: auto;

        }

        .colCodeTwo span:nth-child(1) {

            text-align: right;
            margin-right: 13px; /* Отступ между span-ами */
            margin-left: 32.391%;

        }

        .colCodeTwo span:nth-child(2) {
            width: 50px;
            border: 1px solid #000000;
            text-align: center;
            padding: 2px 8px 2px 8px;
        }

        .colCodeTree{
            margin-top: 5px;
            display: flex; /* Включаем Flexbox */
            align-items: center; /* Выравнивание элементов по вертикали */
            justify-content: flex-end; /* Выравнивание элементов по горизонтали */
        }

        .colCodeTree span:nth-child(1){
            font-size: 12px;
            width: 18%;
            text-align: right;
            display: inline-block;
            height: 15px;
            margin-right: 2%;
        }

        .colCodeTree span:nth-child(2){
            font-size: 12px;
            width: 50%;
            text-align: center;
            display: inline-block;
            height: 15px;
            margin-right: 13.591%;
            border-bottom: 1px solid #000000;
            align-items: center;
        }
        .colCodeTree span:nth-child(3){
            text-align: right;
            margin-right: 13px; /* Отступ между span-ами */

        }

        .colCodeTree span:nth-child(4){
            width: 50px;
            border: 1px solid #000000;
            text-align: left;
            display: inline-block;
            height: 15px;
        }

        .containerNum{
            width: 100%;
            height: 30px;
            margin-top: 10px;
            display: flex; /* Включаем Flexbox */
            align-items: center; /* Выравнивание элементов по вертикали */
            justify-content: flex-end; /* Выравнивание элементов по горизонтали */
        }

        .rowNum{
            width: 50%;
            margin: 0 auto;
        }

        .colNum span:nth-child(1){
            font-size: 15px;
            font-weight: bold;
            font-style: italic;
            display: inline-block;
        }

        .colNum span:nth-child(2){
            width: 30%;
            border-bottom: 1px solid #000000;
            display: inline-block;
            font-size: 12px;
            text-align: center;
        }

        .containerDate{
            width: 100%;
            height: 15px;
            display: flex;
            align-items: center; /* Выравнивание элементов по вертикали */
            justify-content: center; /* Выравнивание элементов по горизонтали */

        }

        .rowDate{
            margin: 0 auto;
            width: 50%;
            font-size: 11px;
            font-weight: bold;
        }

        .colDate span:nth-child(1){
            display: inline-block;
            align-items: center;
            width: 30%;
        }

        .colDate span:nth-child(2):before{
            content: \'"\';
        }
        .colDate span:nth-child(2):after{
            content: \'"\';
        }
        .colDate span:nth-child(2){
            width: 50px;
            display: inline-block;
            border-bottom: 1px solid #000000;
            text-align: center;
        }
        .colDate span:nth-child(3){
            width: 80px;
            display: inline-block;
            border-bottom: 1px solid #000000;
            text-align: center;
        }
        .colDate span:nth-child(4){
            width: 50px;
            display: inline-block;
            border-bottom: 1px solid #000000;
            text-align: center;
        }

        .container_date{
            width: 100%;
            height: 20px;
            margin-top: 10px;
        }

        .row_date{
            font-size: 11px;
        }

        .col_date span:nth-child(1){
            align-items: center;
        }

        .col_date span:nth-child(2):before{
            content: \'"\';
        }

        .col_date span:nth-child(2):after{
            content: \'"\';
        }

        .col_date span:nth-child(2){
            width: 30px;
            border-bottom: 1px solid #000000;
            display: inline-block;
            text-align: center;
            margin-right: 5px;
        }

        .col_date span:nth-child(3){
            width: 80px;
            border-bottom: 1px solid #000000;
            display: inline-block;
            text-align: center;
            margin-right: 5px;
        }

        .container_company{
            width: 100%;
            min-height: 20px;
            margin-top: 5px;
        }

        .row_company{
            font-size: 11px;
        }

        .col_company span:nth-child(1){
            height: auto;
            min-height: 20px;
            border-bottom: 1px solid #000000;
            width: 100%;
            display: inline-block;
            text-align: center;
            box-sizing: border-box; /* Учитываем отступы (padding) */
            word-wrap: break-word;

        }

        .col_company span:nth-child(2):before{
            font-size: 8px;
            content: \' наименование потребителя и его адрес \';
            width: 100%;
            display: inline-block;
            text-align: center;
        }

        .container_pay{
            width: 100%;
            min-height: 20px;
            margin-top: 5px;
        }

        .row_pay{
            font-size: 11px;
        }

        .col_pay span:nth-child(1){
            height: auto;
            min-height: 20px;
            border-bottom: 1px solid #000000;
            width: 100%;
            display: inline-block;
            text-align: center;
            box-sizing: border-box; /* Учитываем отступы (padding) */
            word-wrap: break-word;
        }

        .col_pay span:nth-child(2):before{
            font-size: 8px;
            content: \' наименование плательщика и его адрес \';
            width: 100%;
            display: inline-block;
            text-align: center;
        }

        .container_check{
            width: 100%;
            height: 20px;
            margin-top: 25px;

        }

        .row_check{
            font-size: 11px;

        }

        .col_check span:nth-child(1){
            display: inline-block;
            width: 9%;
            margin-right: 0;
        }

        .col_check span:nth-child(2){
            display: inline-block;
            width: 90.5%;
            border-bottom: 1px solid #000000;
        }

        .col_check span:nth-child(3):before{
            content: \' наименование банка \';
            font-size: 8px;
            display: inline-block;
            text-align: center;
            width: 100%;
            position: relative;  /* Относительное позиционирование */
            top: -5px;           /* Поднимите элемент вверх */
            margin-top: 0;       /* Убираем отступ сверху */
            line-height: normal; /* Устанавливаем нормальное выравнивание по линии */
        }

        .container_user{
            width: 100%;
            height: 30px;
            margin-top: 10px;
        }

        .row_user{
            width: 100%;
            font-size: 11px;
        }

        .col_user span:nth-child(1){
            display: inline-block;
            width: 20%;

        }

        .col_user span:nth-child(2){
            display: inline-block;
            border-bottom: 1px solid #000000;
            width: 79.5%;
        }

        .col_user span:nth-child(3):before{
            content: \' должность \00A0\00A0\00A0\00A0\00A0\00A0 фамилия, имя, отчество \';
            font-size: 8px;
            display: inline-block;
            text-align: center;
            width: 100%;
            position: relative;  /* Относительное позиционирование */
            top: -5px;           /* Поднимите элемент вверх */
            margin-top: 0;       /* Убираем отступ сверху */
            line-height: normal; /* Устанавливаем нормальное выравнивание по линии */
        }

        .container_passport{
            width: 100%;

        }

        .row_passport{
            font-size: 11px;
        }

        .col_passport span:nth-child(1):after{
            content: \': серия \';
        }
        .col_passport span:nth-child(2){
            display: inline-block;
            width: 12%;
            border-bottom: 1px solid #000000;
            text-align: center;
        }
        .col_passport span:nth-child(4){
            display: inline-block;
            width: 15%;
            border-bottom: 1px solid #000000;
            text-align: center;
        }

        .container_iss{
            width: 100%;
            height: 10px;

        }

        .row_iss{
            font-size: 11px;
        }

        .col_iss span:nth-child(1){
            display: inline-block;
            width: 9%;
            margin-right: 15px;
        }

        .col_iss span:nth-child(2){
            display: inline-block;
            width: 88.2%;
            border-bottom: 1px solid #000000;
        }

        .container_iss_date{
            width: 100%;
            height: 20px;
            margin-top: 8px;
        }
        .row_iss_date{
            font-size: 11px;
        }
        .col_iss_date span:nth-child(1){
            width: 15%;
            display: inline-block;
        }
        .col_iss_date span:nth-child(2):before{
            content: \' "\00A0\00A0\ \';
        }
        .col_iss_date span:nth-child(2):after{
            content: \' \00A0\00A0\" \';
        }
        .col_iss_date span:nth-child(2){
            width: 7%;
            display: inline-block;
            text-align: center;
            border-bottom: 1px solid #000000;
        }
        .col_iss_date span:nth-child(3){
            width: 11%;
            display: inline-block;
            text-align: center;
            border-bottom: 1px solid #000000;
        }
        .col_iss_date span:nth-child(4){
            width: 7%;
            display: inline-block;
            text-align: center;
            border-bottom: 1px solid #000000;
        }
        .container_provider{
            width: 100%;
            height: 30px;
            font-size: 11px;
        }
        .col_provider span:nth-child(1){
            display: inline-block;
            width: 15%;
        }
        .col_provider span:nth-child(2){
            display: inline-block;
            width: 84.5%;
            border-bottom: 1px solid #000000;
        }
        .col_provider span:nth-child(3):before{
            content: \' наименование поставщика\';
            font-size: 8px;
            display: inline-block;
            text-align: center;
            width: 100%;
            position: relative;  /* Относительное позиционирование */
            top: -5px;           /* Поднимите элемент вверх */
            margin-top: 0;       /* Убираем отступ сверху */
            line-height: normal; /* Устанавливаем нормальное выравнивание по линии */
        }

        .container_tmc{
            width: 100%;
            height: 30px;
            font-size: 11px;
        }

        .col_tmc span:nth-child(1){
            display: inline-block;
            width: 25%;
        }
        .col_tmc span:nth-child(2){
            display: inline-block;
            border-bottom: 1px solid #000000;
            width: 74.5%;
        }
        .col_tmc span:nth-child(3):before{
            content: \' наименование, номер и дата документа\';
            font-size: 8px;
            display: inline-block;
            text-align: center;
            width: 100%;
            position: relative;  /* Относительное позиционирование */
            top: -5px;           /* Поднимите элемент вверх */
            margin-top: 0;       /* Убираем отступ сверху */
            line-height: normal; /* Устанавливаем нормальное выравнивание по линии */
        }

        .container_table{
            width: 100%;
        }


        .col_table table{
            width: 100%;
            text-align: center;
        }
        .col_table{
        width: 100%;
        display: inline-block;
        }
        .col_table:before{
            content: \' Перечень товарно-материальных ценностей, подлежащих получению\';
            text-align: center;
            display: inline-block;
            width: 100%;
            font-weight: bold;
            font-size: 10px;
        }

        .container_signature_user {
    width: 100%;
    height: 40px;
    font-size: 8px;
    position: relative;  /* Для вертикального расположения дочерних элементов */

}

    .row_signature_user {
        display: block;
        width: 100%;
        height: 20px;
        position: absolute; /* Устанавливаем абсолютное позиционирование */
        bottom: 0; /* Прижимаем к низу контейнера */
    }

    .col_signature_user span:nth-child(1){
    margin-left: 3%;
        display: inline-block;
        width: 30%;
    }
    .col_signature_user span:nth-child(2){
        display: inline-block;
        width: 30%;
        border-bottom: 1px solid #000000;
        margin-right: 15px;
    }

    .container_signature_company {
    width: 100%;
    height: 25px;
    font-size: 8px;
}

.row_signature_company {
    width: 70%;
    height: 40px;
    margin: 0 auto;
    position: relative;

}

.col_signature_company span:nth-child(2),
.col_signature_company span:nth-child(4) {

    display: inline-block;
    width: 30%;
    border-bottom: 1px solid #000000;
    margin-right: 15px;
    position: relative;
    text-align: center;
}

.col_signature_company span:nth-child(2):after {

    content: \'подпись\';
    font-size: 8px;
    position: absolute;
    left: 0;
    top: 1px; /* Текст будет под линией */
    width: 100%;
    text-align: center;
}

.col_signature_company span:nth-child(5):after {
    content: \'расшифровка подписи\';
    font-size: 8px;
    position: absolute;
    left: 60px;
    top: 10px; /* Текст будет под линией */
    width: 100%;
    text-align: center;
}

.container_stamp{
    width: 100%;
    height: 10px;
    font-size: 11px;
}
.row_stamp{
    width: 90%;
    margin: 0 auto;
}


    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="containerHead">
            <div class="rowHead">
                <table>
                    <thead>
                    <tr>
                        <th>Номер доверен.</th>
                        <th>Дата выдачи</th>
                        <th>Срок действия</th>
                        <th>Должность и фамилия лица, которому выдана доверенность</th>
                        <th>Расписка в получении доверенности</th>
                        <th>Поставщик</th>
                        <th>Номер и дата наряда(заменяющего наряда док.) или извещения</th>
                        <th>Номер, дата документа, подтверждающего выполнение поручения</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                        <td>6</td>
                        <td>7</td>
                        <td>8</td>
                    </tr>
                    <tr>
                        <td>'.$info->numder.'</td>
                        <td>'.$info->date_ot['full'].'</td>
                        <td>'.$info->date_do['full'].'</td>
                        <td>'.$info->name.'</td>
                        <td></td>
                        <td>'.$info->nameProvider.'</td>
                        <td></td>
                        <td>'.$info->info.'</td>
                    </tr>
                    </tbody>
                </table>

                <div class="container">
                    <div class="row">
                        <div class="line"></div>
                    </div>
                </div>

            </div>
        </div>
        <div class="containerInfo">
            <div class="rowInfo">
                <span class="oneInfo">Типовая межотраслевая форма № М-2</span>
                <span class="twoInfo">Утверждена постановлением</span>
                <span class="treeInfo">Госкомстата России от 30.10.97 г. № 71а</span>
            </div>
        </div>
        <div class="containerCode">
            <div class="rowCode">
                <div class="colCodeOne">
                    <span>Коды</span>
                </div>
                <div class="colCodeTwo">
                        <span>Форма по ОКУД</span>
                        <span>315001</span>
                </div>
                <div class="colCodeTree">
                    <span>Организация</span>
                    <span>'.$info->nameCompany.'</span>
                    <span>по ОКПО</span>
                    <span>71354842</span>
                </div>
            </div>
        </div>
        <div class="containerNum">
            <div class="rowNum">
                <div class="colNum">
                    <span>Доверенность №</span>
                    <span>'.$info->numder.'</span>
                </div>
            </div>
        </div>
        <div class="containerDate">
            <div class="rowDate">
                <div class="colDate">
                    <span>Дата выдачи</span>
                    <span>'.$info->date_ot['d'].'</span>
                    <span>'.$info->date_ot['m'].'</span>
                    <span>'.$info->date_ot['y'].'</span>
                    <span>г.</span>
                </div>
            </div>
        </div>
        <div class="container_date">
            <div class="row_date">
                <div class="col_date">
                    <span>Доверенность действительна по</span>
                    <span>'.$info->date_do['d'].'</span>
                    <span>'.$info->date_do['m'].'</span>
                    <span>'.$info->date_do['y'].'</span>
                    <span>г.</span>
                </div>
            </div>
        </div>
        <div class="container_company">
            <div class="row_company">
                <div class="col_company">
                    <span>'.$info -> fullname.'</span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="container_pay">
            <div class="row_pay">
                <div class="col_pay">
                    <span>'.$info -> fullname.'</span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="container_check">
            <div class="row_check">
                <div class="col_check">
                    <span>Счет №</span>
                    <span>'.$info -> numberChet.'</span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="container_user">
            <div class="row_user">
                <div class="col_user">
                    <span>Доверенность выдана</span>
                    <span>'.$info -> fullNameLogist.'</span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="container_passport">
            <div class="row_passport">
                <div class="col_passport">
                    <span>'.$info->document.'</span>
                    <span>'.$info->series.'</span>
                    <span>№</span>
                    <span>'.$info->numberDoc.'</span>
                </div>
            </div>
        </div>
        <div class="container_iss">
            <div class="row_iss">
                <div class="col_iss">
                    <span>Кем выдан</span>
                    <span>'.$info->issued.'</span>
                </div>
            </div>
        </div>
        <div class="container_iss_date">
            <div class="row_iss_date">
                <div class="col_iss_date">
                    <span>Дата выдачи</span>
                    <span>'.$info->documentDate['d'].'</span>
                    <span>'.$info->documentDate['m'].'</span>
                    <span>'.$info->documentDate['y'].'</span>
                    <span>г.</span>
                </div>
            </div>
        </div>
        <div class="container_provider">
            <div class="row_provider">
                <div class="col_provider">
                    <span>На получение от</span>
                    <span>'.$info->nameProvider.'</span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="container_tmc">
            <div class="row_tmc">
                <div class="col_tmc">
                    <span>материальных ценностей по</span>
                    <span>'.$info->info.'</span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="container_table">
            <div class="row_table">
                <div class="col_table">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 30px">Номер по порядку</th>
                                <th>Материальные ценности</th>
                                <th style="width: 30px">Единица измерения</th>
                                <th>Количество (прописью)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="container_signature_user">
            <div class="row_signature_user">
                <div class="col_signature_user">
                    <span>Подпись лица, получившего доверенность</span>
                    <span></span>
                    <span>удостоверяем</span>
                </div>
            </div>
        </div>
        <div class="container_signature_company">
            <div class="row_signature_company">
                <div class="col_signature_company">
                    <span>Руководитель</span>
                    <span></span>
                    <span></span>
                    <span>Иванов И. И.</span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="container_stamp">
            <div class="row_stamp">
                <div class="col_stamp">
                    <span>М.П.</span>
                </div>
            </div>
        </div>
        <div class="container_signature_company">
            <div class="row_signature_company">
                <div class="col_signature_company">
                    <span>Главный бухгалтер</span>
                    <span></span>
                    <span></span>
                    <span>Иванов И. И.</span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
';


        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->render();

        $pdfContent = $dompdf->output();
        $filePath = preg_replace('/[\/:*?"<>|]/', '_','Доверенность № '.$info->numder.' от '.$info->date_ot['full'].'.pdf');
        Storage::disk('public')->put($filePath, $pdfContent);
        $url = Storage::url($filePath);
        return response()->json(['url' => $url]);
    }
}
