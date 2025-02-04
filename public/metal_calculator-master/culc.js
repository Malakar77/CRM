document.addEventListener("DOMContentLoaded", () => {
    //Константа плотности для Select
    const steelOptions = [
    {
      steel: [
            { value: "7.8", label: "Ст3", selected: true },
            { value: "7.85", label: "10" },
            { value: "7.85", label: "20" },
            { value: "7.82", label: "40Х" },
            { value: "7.82", label: "45" },
            { value: "7.81", label: "65" },
            { value: "7.85", label: "65Г" },
            { value: "7.85", label: "09Г2С" },
            { value: "7.75", label: "15Х5М" },
            { value: "7.85", label: "10ХСНД" },
            { value: "7.8", label: "12Х1МФ" },
            { value: "7.81", label: "ШХ15" },
            { value: "8.3", label: "Р6М5" },
            { value: "7.83", label: "У7" },
            { value: "7.84", label: "У8" },
            { value: "7.83", label: "У8А" },
            { value: "7.81", label: "У10" },
            { value: "7.81", label: "У10А" },
            { value: "7.81", label: "У12А" },
            { value: "7.8", label: "Прочее" }
      ],
      stainlessSteel:[
            { value: "7.76", label: "08X17T", selected: true },
            { value: "7.67", label: "20X13" },
            { value: "7.67", label: "30X13" },
            { value: "7.65", label: "40Х13" },
            { value: "7.85", label: "08X18Н10" },
            { value: "7.9", label: "12Х18Н10Т" },
            { value: "7.9", label: "10Х17Н13М2Т" },
            { value: "7.96", label: "06ХН28МДТ" },
            { value: "7.9", label: "20Х23Н18" },
            { value: "7.85", label: "AISI 304" },
            { value: "7.8", label: "AISI 316l" },
            { value: "7.95", label: "AISI 316TI" },
            { value: "7.9", label: "AISI 321" },
            { value: "7.76", label: "AISI 409" },
            { value: "7.72", label: "AISI 430" },
            { value: "7.96", label: "AISI 904l" },
            { value: "7.9", label: "Прочее" }
      ],
      aluminum:[
            { value: "2.71", label: "А5", selected: true },
            { value: "2.71", label: "АД" },
            { value: "2.71", label: "АД1" },
            { value: "2.77", label: "АК4" },
            { value: "2.75", label: "АК6" },
            { value: "2.67", label: "АмГ" },
            { value: "2.73", label: "АМц" },
            { value: "2.85", label: "В95" },
            { value: "2.8", label: "Д1" },
            { value: "2.78", label: "Д16" },
            { value: "2.75", label: "Прочее" }
      ],
      cuprum:[
            { value: "8.91", label: "M1", selected: true },
            { value: "8.93", label: "М2" },
            { value: "8.93", label: "М3" },
            { value: "8.92", label: "Прочее" }
      ],
      brass:[
            { value: "8.44", label: "Л63", selected: true },
            { value: "8.6", label: "Л68" },
            { value: "8.5", label: "ЛЖМЦ59-1-1" },
            { value: "8.4", label: "ЛМц58-2" },
            { value: "8.45", label: "ЛС58-2" },
            { value: "8.45", label: "ЛС59-1" },
            { value: "8.5", label: "ЛС63-3" }
      ],
      bronze:[
            { value: "7.6", label: "БрАЖ9-4", selected: true },
            { value: "7.8", label: "БрАЖМц10-3-1,5" },
            { value: "7.5", label: "БрАЖН10-4-4" },
            { value: "7.6", label: "БрАМц9-2" },
            { value: "8.2", label: "БрБ2" },
            { value: "8.4", label: "БрКМЦ3-1" },
            { value: "7.8", label: "БрОФ7-0,2" },
            { value: "8.8", label: "БрОЦС5-5-5" },
            { value: "7.96", label: "Прочее" }
      ],
      titan:[
            { value: "4.505", label: "ВТ1-00", selected: true },
            { value: "4.505", label: "ВТ1-1" },
            { value: "4.43", label: "АТ-6" },
            { value: "4.52", label: "ВТ14" },
            { value: "4.45", label: "ВТ20" },
            { value: "4.6", label: "ВТ22" },
            { value: "4.5", label: "ВТ3-1" },
            { value: "4.4", label: "ВТ5" },
            { value: "4.46", label: "ВТ5-1" },
            { value: "4.43", label: "ВТ6" },
            { value: "4.55", label: "ОТ4-1" },
            { value: "4.49", label: "ПТ7М" },
            { value: "4.5", label: "Прочее" },
      ],
    }
  ];
// Список категорий
    const steel = {
        'Rebar': 'Арматура',
        'IBeam': 'Балка/двутавр',
        'squareBillet': 'Квадрат',
        'rod': 'Круг/пруток',
        'strand': 'Лента',
        'sheet': 'Лист/плита',
        'pipe': 'Труба круглая',
        'squarePipe': 'Труба профильная',
        'angleBar': 'Уголок',
        'channelBeam': 'Швеллер',
        'hexagonSteel': 'Шестигранник',
    };
    const stainlessSteel = {
        'squareBillet': 'Квадрат',
        'rod': 'Круг/пруток',
        'strand': 'Лента',
        'sheet': 'Лист/плита',
        'pipe': 'Труба круглая',
        'squarePipe': 'Труба профильная',
        'angleBar': 'Уголок',
        'hexagonSteel': 'Шестигранник',
    };
    const aluminum = {
        'squareBillet': 'Квадрат',
        'rod': 'Круг/пруток',
        'strand': 'Лента',
        'sheet': 'Лист/плита',
        'pipe': 'Труба круглая',
        'squarePipe': 'Труба профильная',
        'angleBar': 'Уголок',
        'hexagonSteel': 'Шестигранник',
    };
    const cuprum = {
        'rod': 'Круг/пруток',
        'strand': 'Лента',
        'sheet': 'Лист/плита',
        'pipe': 'Труба круглая',
    };
    const brass = {
        'rod': 'Круг/пруток',
        'strand': 'Лента',
        'sheet': 'Лист/плита',
        'pipe': 'Труба круглая',
        'hexagonSteel': 'Шестигранник',
    };
    const bronze = {
        'rod': 'Круг/пруток',
        'strand': 'Лента',
        'sheet': 'Лист/плита',
    };
    const titan = {
        'rod': 'Круг/пруток',
        'strand': 'Лента',
        'sheet': 'Лист/плита',
        'pipe': 'Труба круглая',
        'squarePipe': 'Труба профильная',
    };
    const linkImg = [
        'img/Armature.png',
        'img/Balk.png',
        'img/Branch.png',
        'img/ChannelP.png',
        'img/Circle.png',
        'img/Corner.png',
        'img/Flange.png',
        'img/Hexahedron.png',
        'img/List.png',
        'img/PipeCircle.png',
        'img/PipeProf.png',
        'img/Ribbon.png',
        'img/Square.png',
    ];
    const imgClass= [
        'shape-armature',
        'shape-balk',
        'shape-square',
        'shape-circle',
        'shape-ribbon',
        'shape-list',
        'shape-branch',
        'shape-pipeCircle',
        'shape-pipeProf',
        'shape-corner',
        'shape-flange',
        'shape-channelp',
        'shape-hexahedron'
    ];

   // html верстка форм для каждой категории
    let formRebar = `
<div><div><label for="country">
  	<span class="field-label">Номинальный диаметр</span>
    <select class="width-100" name="d" data-region="options">
      
        <option value="6">6</option>
      
        <option value="8">8</option>
      
        <option value="10">10</option>
      
        <option value="12">12</option>
      
        <option value="14">14</option>
      
        <option value="16">16</option>
      
        <option value="18">18</option>
      
        <option value="20">20</option>
      
        <option value="22">22</option>
      
        <option value="25">25</option>
      
        <option value="28">28</option>
      
        <option value="32">32</option>
      
        <option value="36">36</option>
      
    </select>
</label>
</div><div><label>
	<span class="field-label">Длина L</span>
	<input class="width-100" name="l" type="text" placeholder="0">
  <span class="input-append">м.</span>
</label>
</div><a class="btn main-btn btn-green width-100">Рассчитать</a></div>
`;  
    let formIBeam = `
<div><div><label for="country"> 
</label>
</div><div><label for="country">
  	<span class="field-label">Номер балки</span>
    <select class="width-100 numBalk" name="balk" data-region="options">
      
        <option value="8.7">10Б1</option>
      
        <option value="10.4">12Б1</option>
      
        <option value="10.37">12Б2</option>
      
        <option value="10.1">14Б1</option>
      
        <option value="12.9">14Б2</option>
      
        <option value="12.7">16Б1</option>
      
        <option value="15.8">16Б2</option>
      
        <option value="15.4">18Б1</option>
      
        <option value="18.8">18Б2</option>
      
        <option value="22.4">20Б1</option>
      
        <option value="25.8">23Б1</option>
      
        <option value="28">26Б1</option>
      
        <option value="31.2">26Б2</option>
      
        <option value="32.9">30Б1</option>
      
        <option value="36.6">30Б2</option>
      
        <option value="38.9">35Б1</option>
      
        <option value="43.3">35Б2</option>
      
        <option value="48.1">40Б1</option>
      
        <option value="54.7">40Б2</option>
      
        <option value="59.8">45Б1</option>
      
        <option value="67.5">45Б2</option>
      
        <option value="73">50Б1</option>
      
        <option value="80.7">50Б2</option>
      
        <option value="89">55Б1</option>
      
        <option value="97.9">55Б2</option>
      
        <option value="106.2">60Б1</option>
      
        <option value="115.6">60Б2</option>
      
        <option value="129.3">70Б1</option>
      
        <option value="144.2">70Б2</option>
      
        <option value="159.5">80Б1</option>
      
        <option value="177.9">80Б2</option>
      
        <option value="194">90Б1</option>
      
        <option value="213.8">90Б2</option>
      
        <option value="230.6">100Б1</option>
      
        <option value="258.2">100Б2</option>
      
        <option value="285.7">100Б3</option>
      
        <option value="314.5">100Б4</option>
      
    </select>
</label>
</div><div><label>
	<span class="field-label">Длина L</span>
	<input class="width-100" name="l" type="text" placeholder="0">
  <span class="input-append">м.</span>
</label>
</div><a class="btn main-btn btn-green width-100">Рассчитать</a></div>
`;
    let formSquareBillet = `
<div><div><label for="country">
  	<span class="field-label">Марка стали</span>
    <select class="width-100" name="p" data-region="options">
      
        <option value="7.8" selected="">Ст 3</option>
      
        <option value="7.85">10</option>
      
        <option value="7.85">20</option>
      
        <option value="7.82">40Х</option>
      
        <option value="7.82">45</option>
      
        <option value="7.81">65</option>
      
        <option value="7.85">65Г</option>
      
        <option value="7.85">09Г2С</option>
      
        <option value="7.75">15Х5М</option>
      
        <option value="7.85">10ХСНД</option>
      
        <option value="7.8">12Х1МФ</option>
      
        <option value="7.81">ШХ15</option>
      
        <option value="8.3">Р6М5</option>
      
        <option value="7.83">У7</option>
      
        <option value="7.84">У8</option>
      
        <option value="7.83">У8А</option>
      
        <option value="7.81">У10</option>
      
        <option value="7.81">У10А</option>
      
        <option value="7.81">У12А</option>
      
        <option value="7.8">Прочее</option>
      
    </select>
</label>
</div><div><label>
	<span class="field-label">Сторона квадрата а</span>
	<input class="width-100 storona" name="a" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Длина L</span>
	<input class="width-100 width" name="l" type="text" placeholder="0">
  <span class="input-append">м.</span>
</label>
</div><a class="btn main-btn btn-green width-100">Рассчитать</a></div>
`;
    let formRod = `
<div><div><label for="country">
  	<span class="field-label">Марка стали</span>
    <select class="width-100" name="p" data-region="options">
      
        <option value="7.8" selected="">Ст 3</option>
      
        <option value="7.85">10</option>
      
        <option value="7.85">20</option>
      
        <option value="7.82">40Х</option>
      
        <option value="7.82">45</option>
      
        <option value="7.81">65</option>
      
        <option value="7.85">65Г</option>
      
        <option value="7.85">09Г2С</option>
      
        <option value="7.75">15Х5М</option>
      
        <option value="7.85">10ХСНД</option>
      
        <option value="7.8">12Х1МФ</option>
      
        <option value="7.81">ШХ15</option>
      
        <option value="8.3">Р6М5</option>
      
        <option value="7.83">У7</option>
      
        <option value="7.84">У8</option>
      
        <option value="7.83">У8А</option>
      
        <option value="7.81">У10</option>
      
        <option value="7.81">У10А</option>
      
        <option value="7.81">У12А</option>
      
        <option value="7.8">Прочее</option>
      
    </select>
</label>
</div><div><label>
	<span class="field-label">Диаметр круга D</span>
	<input class="width-100 dia" name="d" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Длина L</span>
	<input class="width-100 width" name="l" type="text" placeholder="0">
  <span class="input-append">м.</span>
</label>
</div><a class="btn main-btn btn-green width-100">Рассчитать</a></div>
`;
    let formStrand = `
<div><div><label for="country">
  	<span class="field-label">Марка стали</span>
    <select class="width-100" name="p" data-region="options">
      
        <option value="7.8" selected="">Ст 3</option>
      
        <option value="7.85">10</option>
      
        <option value="7.85">20</option>
      
        <option value="7.82">40Х</option>
      
        <option value="7.82">45</option>
      
        <option value="7.81">65</option>
      
        <option value="7.85">65Г</option>
      
        <option value="7.85">09Г2С</option>
      
        <option value="7.75">15Х5М</option>
      
        <option value="7.85">10ХСНД</option>
      
        <option value="7.8">12Х1МФ</option>
      
        <option value="7.81">ШХ15</option>
      
        <option value="8.3">Р6М5</option>
      
        <option value="7.83">У7</option>
      
        <option value="7.84">У8</option>
      
        <option value="7.83">У8А</option>
      
        <option value="7.81">У10</option>
      
        <option value="7.81">У10А</option>
      
        <option value="7.81">У12А</option>
      
        <option value="7.8">Прочее</option>
      
    </select>
</label>
</div><div><label>
	<span class="field-label">Ширина ленты a</span>
	<input class="width-100 height" name="a" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Толщина ленты t</span>
	<input class="width-100 size" name="t" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Длина L</span>
	<input class="width-100 width" name="b" type="text" placeholder="0">
  <span class="input-append">м.</span>
</label>
</div><a class="btn main-btn btn-green width-100">Рассчитать</a></div>
`;
    let formSheet = `
<div><div><label for="country">
  	<span class="field-label">Марка стали</span>
    <select class="width-100" name="p" data-region="options">
      
        <option value="7.8" selected="">Ст 3</option>
      
        <option value="7.85">10</option>
      
        <option value="7.85">20</option>
      
        <option value="7.82">40Х</option>
      
        <option value="7.82">45</option>
      
        <option value="7.81">65</option>
      
        <option value="7.85">65Г</option>
      
        <option value="7.85">09Г2С</option>
      
        <option value="7.75">15Х5М</option>
      
        <option value="7.85">10ХСНД</option>
      
        <option value="7.8">12Х1МФ</option>
      
        <option value="7.81">ШХ15</option>
      
        <option value="8.3">Р6М5</option>
      
        <option value="7.83">У7</option>
      
        <option value="7.84">У8</option>
      
        <option value="7.83">У8А</option>
      
        <option value="7.81">У10</option>
      
        <option value="7.81">У10А</option>
      
        <option value="7.81">У12А</option>
      
        <option value="7.8">Прочее</option>
      
    </select>
</label>
</div><div><label>
	<span class="field-label">Толщина листа t</span>
	<input class="width-100 size" name="t" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Ширина листа a</span>
	<input class="width-100 width" name="a" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Длина листа b</span>
	<input class="width-100 height" name="b" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Количество</span>
	<input class="width-100 count" name="n" type="text" placeholder="0">
  <span class="input-append">шт.</span>
</label>
</div><a class="btn main-btn btn-green width-100">Рассчитать</a></div>
`;
    let formPipe = `
<div><div><label for="country">
  	<span class="field-label">Марка стали</span>
    <select class="width-100" name="p" data-region="options">
      
        <option value="7.8" selected="">Ст 3</option>
      
        <option value="7.85">10</option>
      
        <option value="7.85">20</option>
      
        <option value="7.82">40Х</option>
      
        <option value="7.82">45</option>
      
        <option value="7.81">65</option>
      
        <option value="7.85">65Г</option>
      
        <option value="7.85">09Г2С</option>
      
        <option value="7.75">15Х5М</option>
      
        <option value="7.85">10ХСНД</option>
      
        <option value="7.8">12Х1МФ</option>
      
        <option value="7.81">ШХ15</option>
      
        <option value="8.3">Р6М5</option>
      
        <option value="7.83">У7</option>
      
        <option value="7.84">У8</option>
      
        <option value="7.83">У8А</option>
      
        <option value="7.81">У10</option>
      
        <option value="7.81">У10А</option>
      
        <option value="7.81">У12А</option>
      
        <option value="7.8">Прочее</option>
      
    </select>
</label>
</div><div><label>
	<span class="field-label">Внешний диаметр трубы D</span>
	<input class="width-100 dia" name="d" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Толщина стенки t</span>
	<input class="width-100 width" name="t" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Длина L</span>
	<input class="width-100 length" name="l" type="text" placeholder="0">
  <span class="input-append">м.</span>
</label>
</div><a class="btn main-btn btn-green width-100">Рассчитать</a></div>
`;
    let formSquarePipe = `
<div><div><label for="country">
  	<span class="field-label">Марка стали</span>
    <select class="width-100" name="p" data-region="options">
      
        <option value="7.8" selected="">Ст 3</option>
      
        <option value="7.85">10</option>
      
        <option value="7.85">20</option>
      
        <option value="7.82">40Х</option>
      
        <option value="7.82">45</option>
      
        <option value="7.81">65</option>
      
        <option value="7.85">65Г</option>
      
        <option value="7.85">09Г2С</option>
      
        <option value="7.75">15Х5М</option>
      
        <option value="7.85">10ХСНД</option>
      
        <option value="7.8">12Х1МФ</option>
      
        <option value="7.81">ШХ15</option>
      
        <option value="8.3">Р6М5</option>
      
        <option value="7.83">У7</option>
      
        <option value="7.84">У8</option>
      
        <option value="7.83">У8А</option>
      
        <option value="7.81">У10</option>
      
        <option value="7.81">У10А</option>
      
        <option value="7.81">У12А</option>
      
        <option value="7.8">Прочее</option>
      
    </select>
</label>
</div><div><label>
	<span class="field-label">Ширина трубы a</span>
	<input class="width-100 width" name="a" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Высота трубы b</span>
	<input class="width-100 height" name="b" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Толщина стенки t</span>
	<input class="width-100 size" name="t" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Длина L</span>
	<input class="width-100 length" name="l" type="text" placeholder="0">
  <span class="input-append">м.</span>
</label>
</div><a class="btn main-btn btn-green width-100">Рассчитать</a></div>
`;
    let formAngleBar = `
<div><div><label for="country">
  	<span class="field-label">Марка стали</span>
    <select class="width-100" name="p" data-region="options">
      
        <option value="7.8" selected="">Ст 3</option>
      
        <option value="7.85">10</option>
      
        <option value="7.85">20</option>
      
        <option value="7.82">40Х</option>
      
        <option value="7.82">45</option>
      
        <option value="7.81">65</option>
      
        <option value="7.85">65Г</option>
      
        <option value="7.85">09Г2С</option>
      
        <option value="7.75">15Х5М</option>
      
        <option value="7.85">10ХСНД</option>
      
        <option value="7.8">12Х1МФ</option>
      
        <option value="7.81">ШХ15</option>
      
        <option value="8.3">Р6М5</option>
      
        <option value="7.83">У7</option>
      
        <option value="7.84">У8</option>
      
        <option value="7.83">У8А</option>
      
        <option value="7.81">У10</option>
      
        <option value="7.81">У10А</option>
      
        <option value="7.81">У12А</option>
      
        <option value="7.8">Прочее</option>
      
    </select>
</label>
</div><div><label>
	<span class="field-label">Ширина уголка a</span>
	<input class="width-100 a" name="a" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Высота уголка b</span>
	<input class="width-100 b" name="b" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Толщина полки t</span>
	<input class="width-100 t" name="t" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Длина L</span>
	<input class="width-100 l" name="l" type="text" placeholder="0">
  <span class="input-append">м.</span>
</label>
</div><a class="btn main-btn btn-green width-100">Рассчитать</a></div>
`;
    let formChannelBeam = `
<div><div><label for="country">
  	<span class="field-label">Номер швеллера</span>
    <select class="width-100" name="d" data-region="options">
      
        <option value="4.84">5П</option>
      
        <option value="4.84">5У</option>
      
        <option value="5.9">6,5П</option>
      
        <option value="5.9">6,5У</option>
      
        <option value="7.05">8П</option>
      
        <option value="7.05">8У</option>
      
        <option value="8.59">10П</option>
      
        <option value="8.59">10У</option>
      
        <option value="10.4">12П</option>
      
        <option value="10.4">12У</option>
      
        <option value="12.3">14П</option>
      
        <option value="12.3">14у</option>
      
        <option value="15.3">16аП</option>
      
        <option value="14.2">16П</option>
      
        <option value="14.2">16у</option>
      
        <option value="17.4">18аП</option>
      
        <option value="17.4">18аУ</option>
      
        <option value="16.3">18П</option>
      
        <option value="16.3">18у</option>
      
        <option value="18.4">20П</option>
      
        <option value="21">20У</option>
      
        <option value="18.4">20У</option>
      
        <option value="21">22П</option>
      
        <option value="24">24П</option>
      
        <option value="24">24У</option>
      
        <option value="27.7">27П</option>
      
        <option value="31.8">30П</option>
      
        <option value="31.8">30У</option>
      
        <option value="36.5">33П</option>
      
        <option value="36.5">33У</option>
      
        <option value="41.9">36П</option>
      
        <option value="41.9">36у</option>
      
        <option value="48.3">40П</option>
      
        <option value="48.3">40У</option>
      
    </select>
</label>
</div><div><label>
	<span class="field-label">Длина L</span>
	<input class="width-100 l" name="l" type="text" placeholder="0">
  <span class="input-append">м.</span>
</label>
</div><a class="btn main-btn btn-green width-100">Рассчитать</a></div>
`;
    let formHexagonSteel = `
<div><div><label for="country">
  	<span class="field-label">Марка стали</span>
    <select class="width-100" name="p" data-region="options">
      
        <option value="7.8" selected="">Ст 3</option>
      
        <option value="7.85">10</option>
      
        <option value="7.85">20</option>
      
        <option value="7.82">40Х</option>
      
        <option value="7.82">45</option>
      
        <option value="7.81">65</option>
      
        <option value="7.85">65Г</option>
      
        <option value="7.85">09Г2С</option>
      
        <option value="7.75">15Х5М</option>
      
        <option value="7.85">10ХСНД</option>
      
        <option value="7.8">12Х1МФ</option>
      
        <option value="7.81">ШХ15</option>
      
        <option value="8.3">Р6М5</option>
      
        <option value="7.83">У7</option>
      
        <option value="7.84">У8</option>
      
        <option value="7.83">У8А</option>
      
        <option value="7.81">У10</option>
      
        <option value="7.81">У10А</option>
      
        <option value="7.81">У12А</option>
      
        <option value="7.8">Прочее</option>
      
    </select>
</label>
</div><div><label>
	<span class="field-label">Номер шестигранника a</span>
	<input class="width-100 dia" name="a" type="text" placeholder="0">
  <span class="input-append">мм.</span>
</label>
</div><div><label>
	<span class="field-label">Длина L</span>
	<input class="width-100 length" name="l" type="text" placeholder="0">
  <span class="input-append">м.</span>
</label>
</div><a class="btn main-btn btn-green width-100">Рассчитать</a></div>
`;

// Создаем объект с соответствиями
    const steelMap = {
        'steel': steel,
        'stainlessSteel': stainlessSteel,
        'aluminum': aluminum,
        'cuprum': cuprum,
        'brass': brass,
        'bronze': bronze,
        'titan': titan
    };

// Создаем объект с соответствиями
    const itemsMap = {
        'Rebar': {
            imgIndex: 0,
            form: formRebar,
            inputsFunc: inputs,
            culcFunc: culcArma
        },
        'IBeam': {
            imgIndex: 1,
            form: formIBeam,
            inputsFunc: inputs,
            culcFunc: culcBalka
        },
        'squareBillet': {
            imgIndex: 12,
            form: formSquareBillet,
            inputsFunc: inputs,
            switchFunc: function() {
                switch (search()) {
                    case 'steel':
                        addSelect(steelOptions[0].steel);
                        break;
                    case 'stainlessSteel':
                        addSelect(steelOptions[0].stainlessSteel);
                        break;
                    case 'aluminum':
                        addSelect(steelOptions[0].aluminum);
                        break;
                    default:
                        break;
                }
            },
            culcFunc: culcCube
        },
        'rod': {
            imgIndex: 4,
            form: formRod,
            inputsFunc: inputs,
            switchFunc: function() {
                switch (search()) {
                    case 'steel':
                        addSelect(steelOptions[0].steel);
                        break;
                    case 'stainlessSteel':
                        addSelect(steelOptions[0].stainlessSteel);
                        break;
                    case 'aluminum':
                        addSelect(steelOptions[0].aluminum);
                        break;
                    case 'cuprum':
                        addSelect(steelOptions[0].cuprum);
                        break;
                    case 'brass':
                        addSelect(steelOptions[0].brass);
                        break;
                    case 'bronze':
                        addSelect(steelOptions[0].bronze);
                        break;
                    case 'titan':
                        addSelect(steelOptions[0].titan);
                        break;
                    default:
                        break;
                }
            },
            culcFunc: culcCrug
        },
        'strand': {
            imgIndex: 11,
            form: formStrand,
            inputsFunc: inputs,
            switchFunc: function() {
                switch (search()) {
                    case 'steel':
                        addSelect(steelOptions[0].steel);
                        break;
                    case 'stainlessSteel':
                        addSelect(steelOptions[0].stainlessSteel);
                        break;
                    case 'aluminum':
                        addSelect(steelOptions[0].aluminum);
                        break;
                    case 'cuprum':
                        addSelect(steelOptions[0].cuprum);
                        break;
                    case 'brass':
                        addSelect(steelOptions[0].brass);
                        break;
                    case 'bronze':
                        addSelect(steelOptions[0].bronze);
                        break;
                    case 'titan':
                        addSelect(steelOptions[0].titan);
                        break;
                    default:
                        break;
                }
            },
            culcFunc: culcLenta
        },
        'sheet': {
            imgIndex: 8,
            form: formSheet,
            inputsFunc: inputs,
            switchFunc: function() {
                switch (search()) {
                    case 'steel':
                        addSelect(steelOptions[0].steel);
                        break;
                    case 'stainlessSteel':
                        addSelect(steelOptions[0].stainlessSteel);
                        break;
                    case 'aluminum':
                        addSelect(steelOptions[0].aluminum);
                        break;
                    case 'cuprum':
                        addSelect(steelOptions[0].cuprum);
                        break;
                    case 'brass':
                        addSelect(steelOptions[0].brass);
                        break;
                    case 'bronze':
                        addSelect(steelOptions[0].bronze);
                        break;
                    case 'titan':
                        addSelect(steelOptions[0].titan);
                        break;
                    default:
                        break;
                }
            },
            culcFunc: culcList
        },
        'pipe': {
            imgIndex: 9,
            form: formPipe,
            inputsFunc: inputs,
            switchFunc: function() {
                switch (search()) {
                    case 'steel':
                        addSelect(steelOptions[0].steel);
                        break;
                    case 'stainlessSteel':
                        addSelect(steelOptions[0].stainlessSteel);
                        break;
                    case 'aluminum':
                        addSelect(steelOptions[0].aluminum);
                        break;
                    case 'cuprum':
                        addSelect(steelOptions[0].cuprum);
                        break;
                    case 'brass':
                        addSelect(steelOptions[0].brass);
                        break;
                    case 'titan':
                        addSelect(steelOptions[0].titan);
                        break;
                    default:
                        break;
                }
            },
            culcFunc: culcTrubaKr
        },
        'squarePipe': {
            imgIndex: 10,
            form: formSquarePipe,
            inputsFunc: inputs,
            switchFunc: function() {
                switch (search()) {
                    case 'steel':
                        addSelect(steelOptions[0].steel);
                        break;
                    case 'stainlessSteel':
                        addSelect(steelOptions[0].stainlessSteel);
                        break;
                    case 'aluminum':
                        addSelect(steelOptions[0].aluminum);
                        break;
                    case 'titan':
                        addSelect(steelOptions[0].titan);
                        break;
                    default:
                        break;
                }
            },
            culcFunc: culcTrubaPr
        },
        'angleBar': {
            imgIndex: 5,
            form: formAngleBar,
            inputsFunc: inputs,
            switchFunc: function() {
                switch (search()) {
                    case 'steel':
                        addSelect(steelOptions[0].steel);
                        break;
                    case 'stainlessSteel':
                        addSelect(steelOptions[0].stainlessSteel);
                        break;
                    case 'aluminum':
                        addSelect(steelOptions[0].aluminum);
                        break;
                    default:
                        break;
                }
            },
            culcFunc: culcUgolok
        },
        'channelBeam': {
            imgIndex: 3,
            form: formChannelBeam,
            inputsFunc: inputs,
            culcFunc: culcShveler
        },
        'hexagonSteel': {
            imgIndex: 7,
            form: formHexagonSteel,
            inputsFunc: inputs,
            switchFunc: function() {
                switch (search()) {
                    case 'steel':
                        addSelect(steelOptions[0].steel);
                        break;
                    case 'stainlessSteel':
                        addSelect(steelOptions[0].stainlessSteel);
                        break;
                    case 'aluminum':
                        addSelect(steelOptions[0].aluminum);
                        break;
                    case 'brass':
                        addSelect(steelOptions[0].brass);
                        break;
                    default:
                        break;
                }
            },
            culcFunc: culcShest
        },
    };

    /**
     * Добавление класса active элементу, по которому произошёл клик
     */
    const nav = document.querySelectorAll('nav');
    nav.forEach(item =>{
        item.addEventListener('click', (e)=>{
            let metall = e.target.closest('ul');
            for (let i = 0; i < metall.children.length; i++) {
                metall.children[i].classList.remove('active');
            }
            e.target.parentNode.classList.add("active");
        })
    })
// Получаем все элементы навигации
    const navItems = document.querySelectorAll('a');
// Добавляем один обработчик для всех элементов навигации
    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            // Получаем текст элемента, на котором произошло событие
            const steelType = e.target.dataset.value;
            // Проверяем, есть ли соответствие в объекте steelMap и вызываем соответствующую функцию
            if (steelMap.hasOwnProperty(steelType)) {
                addSteel(steelMap[steelType]);
            }
        });
    });

// Добавляем один обработчик для всех элементов навигации
    nav.forEach(item => {
        item.addEventListener('click', (e) => {
            // Получаем текст элемента на котором произошло событие
            const itemType = e.target.dataset.value;
            // Проверяем, есть ли соответствие в объекте itemsMap
            if (itemsMap.hasOwnProperty(itemType)) {
                const itemConfig = itemsMap[itemType];
                imgadd(linkImg, itemConfig.imgIndex, imgClass, itemConfig.imgIndex);
                addForm(itemConfig.form);
                itemConfig.inputsFunc();
                if (itemConfig.switchFunc) {
                    itemConfig.switchFunc();
                }
                itemConfig.culcFunc();
            }
        });
    });
    // Вызов функции для категории по умолчанию
    culcTrubaKr();
    inputs();
    /**
     * функция добавления категорий
     */
function addSteel(steel){
        // Создаем объект с соответствиями
    let unit60 = document.querySelector('.unit-60');
    let block = unit60.querySelector('ul')
    let child = block.querySelectorAll('li');
    for (let i = 0; i < child.length; i++) {
        block.removeChild(child[i]);
    }
    for (let key in steel) {
        if (steel.hasOwnProperty(key)) {
            let chil_not = document.createElement('li');
            chil_not.innerHTML = `<a onclick="return false;" href="#" data-value="${key}">${steel[key]}</a>`;
            block.append(chil_not);
        }
    }
}
    /**
     * Функция выбора вида металла
     * @returns {string}
     */
    function search() {
        const items = document.querySelectorAll('ul[data-region="metall-list"] li');
        const activeItem = [...items].find(item => item.classList.contains('active'));
        if (activeItem) {
            return activeItem.children[0].dataset.value;
        }
        return null; // Возвращаем null если активный элемент не найден
    }

    /**
     * событие change обнуление при вводе спец символов и запятый в инпут
     */
    function inputs(){
    let inputs = document.querySelectorAll("input");
    inputs.forEach(function(input) {
        input.addEventListener("change", function() {
            this.value = this.value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
        });
    });
}
    /**
     * Заполнение select при выборе вида металла
     * @param steelOptions
     */
    function addSelect(steelOptions){
    const select = document.querySelector('select');
    while (select.firstChild) {
        select.removeChild(select.firstChild);
    }
    for(let i = 0; i<steelOptions.length; i++ ){
        // Создаем новый элемент option
        const newOption = document.createElement('option');

        // Устанавливаем значение и текст новой опции
        newOption.value = steelOptions[i].value;
        newOption.text = steelOptions[i].label;
        newOption.selected = steelOptions[i].selected ? true : '';
        // Добавляем новую опцию в конец select
        select.appendChild(newOption);
    }

}
    /**
     * Добавление картинки профиля металла
     * @param linkImg
     * @param i
     * @param imgClass
     * @param b
     */
    function imgadd(linkImg, i, imgClass, b){
    let parImg = document.querySelector('.img');
    let img = document.querySelector('.pane-img');
    parImg.removeChild(img);

    let imgAdd = document.createElement('img');
    
    imgAdd.className = "pane-img " + imgClass[b];
    imgAdd.src = linkImg[i];
    parImg.append(imgAdd)
}
    /**
     * Добавление формы при выборе сортамента
     * @param formArmat
     */
function addForm (formArmat){
    let forms = document.querySelector('.forms');
    let childForm = document.querySelector('.childForm');
    forms.removeChild(childForm);
    let newForm = document.createElement('div');
        newForm.className = "childForm";
        newForm.innerHTML = formArmat;
    forms.append(newForm);
}
    /**
     * Подсчет веса арматуры
     */
    function culcArma(){
    let submit = document.querySelector('.btn-green');
    submit.addEventListener('click', ()=>{
        let select = document.querySelector('select').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
        let input = document.querySelector('input').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
        let result = (((Number(select)*Number(select)*3.14)/4)*7.85)/1000;
        let result2 = result*input;
        document.querySelectorAll('.result-item-value')[1].textContent = result2.toFixed(3) + ' кг';
    })
}
    /**
     * Подсчет веса балки
     */
    function culcBalka (){
  let submit = document.querySelector('.btn-green');
  submit.addEventListener('click', ()=>{
    let select = document.querySelector('select.numBalk').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let input = document.querySelector('input').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let result = Number(select)*Number(input);
    document.querySelectorAll('.result-item-value')[1].textContent = result.toFixed(3) + ' кг';
  })
}
    /**
     * Подсчет веса квадрата
     */
    function culcCube(){
  let submit = document.querySelector('.btn-green');
  submit.addEventListener('click', ()=>{
    let select = document.querySelector('select').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputSt = document.querySelector('input.storona').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputWh = document.querySelector('input.width').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let result = ((select*(inputSt*inputSt))*inputWh)/1000;
    document.querySelectorAll('.result-item-value')[1].textContent = result.toFixed(3) + ' кг';
  })
}
    /**
     * Подсчет веса Круга/Прутка
     */
    function culcCrug (){
  let submit = document.querySelector('.btn-green');
  submit.addEventListener('click', ()=>{
    let select = document.querySelector('select').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputSt = document.querySelector('input.dia').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputWh = document.querySelector('input.width').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let result = (3.14*(Number(inputSt)*Number(inputSt))/4*Number(inputWh)*Number(select))/1000;
    document.querySelectorAll('.result-item-value')[1].textContent = result.toFixed(3) + ' кг';
  })
}
    /**
     * Подсчет веса ленты
     */
    function culcLenta(){
  let submit = document.querySelector('.btn-green');
  submit.addEventListener('click', ()=>{
    let select = document.querySelector('select').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputHv = document.querySelector('input.height').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputWh = document.querySelector('input.width').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputSz = document.querySelector('input.size').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let result = (inputSz * inputHv * inputWh * select) /1000;
    document.querySelectorAll('.result-item-value')[1].textContent = result.toFixed(3) + ' кг';
  })
}
    /**
     * Подсчет веса листа
     */
    function culcList(){
  let submit = document.querySelector('.btn-green');
  submit.addEventListener('click', ()=>{
    let select = document.querySelector('select').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputHv = document.querySelector('input.height').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputWh = document.querySelector('input.width').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputSz = document.querySelector('input.size').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputCnt = document.querySelector('input.count').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let result = ((inputSz * inputHv * inputWh * select) * inputCnt)/1000000;
    document.querySelectorAll('.result-item-value')[1].textContent = result.toFixed(3) + ' кг';
  })
}
    /**
     * Подсчет веса трубы круглой
     */
    function culcTrubaKr(){
  let submit = document.querySelector('.btn-green');
  submit.addEventListener('click', ()=>{
    let select = document.querySelector('select').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputDia = document.querySelector('input.dia').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputWh = document.querySelector('input.width').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputLg = document.querySelector('input.length').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let result = ((3.14 * (inputDia - inputWh) * inputWh * select) * inputLg) / 1000;
    console.log(inputDia - inputWh)
    document.querySelectorAll('.result-item-value')[1].textContent = result.toFixed(3) + ' кг';
  })
}
    /**
     * Подсчет веса трубы профильной
     */
    function culcTrubaPr(){
  let submit = document.querySelector('.btn-green');
  submit.addEventListener('click', ()=>{
    let select = document.querySelector('select').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputHv = document.querySelector('input.height').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputWh = document.querySelector('input.width').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputSz = document.querySelector('input.size').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let inputLg = document.querySelector('input.length').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
    let result = ((2 * (parseFloat(inputHv) + parseFloat(inputWh)) * parseFloat(inputSz) * parseFloat(select)) * parseFloat(inputLg))/1000;
    document.querySelectorAll('.result-item-value')[1].textContent = result.toFixed(3) + ' кг';
  })
}
    /**
     * Подсчет веса уголка
     */
    function culcUgolok() {
    let submit = document.querySelector('.btn-green');
    submit.addEventListener('click', () => {
        let select = document.querySelector('select').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
        let inputA = document.querySelector('input.a').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
        let inputB = document.querySelector('input.b').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
        let inputT = document.querySelector('input.t').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
        let inputL = document.querySelector('input.l').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
        let square = (parseFloat(inputA) + parseFloat(inputB) - parseFloat(inputT)) * parseFloat(inputT);
        let result = (parseFloat(select) * square * parseFloat(inputL)) / 1000;
        document.querySelectorAll('.result-item-value')[1].textContent = result.toFixed(3) + ' кг';
    })
}
    /**
     * Подсчет веса швеллера
     */
    function culcShveler(){
    let submit = document.querySelector('.btn-green');
    submit.addEventListener('click', () => {
        let select = document.querySelector('select').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
        let inputL = document.querySelector('input.l').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
        let result = parseFloat(select) * parseFloat(inputL);
        document.querySelectorAll('.result-item-value')[1].textContent = result.toFixed(3) + ' кг';
    })
}
    /**
     * Подсчет веса Шестигранника
     */
    function culcShest(){
    let submit = document.querySelector('.btn-green');
    submit.addEventListener('click', () => {
        let select = document.querySelector('select').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
        let inputA = document.querySelector('input.dia').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
        let inputB = document.querySelector('input.length').value.replace(/[^0-9,.]/g, ' ').replace(/\s/g, '');
        let total = (3.464*inputA/2*inputA/2*select)/1000;
        let result = total* inputB;
        document.querySelectorAll('.result-item-value')[1].textContent = result.toFixed(3) + ' кг';
    })
}


})