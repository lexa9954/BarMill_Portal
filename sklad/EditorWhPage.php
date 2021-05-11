<div id="debug"></div>

<a href="/SOFT/app.config" download>скачать</a>
<div id="creatorWHpage">
<div class="createWarehouse" >
    <h1 >Имя склада</h1>
    <input type="text" id="nameWH"/>
    <hr>
    <h1 >Размеры помещения</h1>
    <h2 >
    Ширина<input type="text" id="whW"/>
    Высота<input type="text" id="whH"/>
    Глубина<input type="text" id="whZ"/>
    </h2>
    <hr>
    <h1 >Количество стелажей на складе</h1>
    <input id="countStelaj" type="text"/>
    
    <div>
        <input type="button" value =">" onclick="next('stelaj')">
    </div>
</div>
</div>

<script>
    
    var newWareHouse = {
        "whName":"newWH",
        "whSizeW":0,
        "whSizeH":0,
        "whSizeZ":0,
        "stelaji":[
            {
                "stSizeW":0,
                "stSizeH":0,
                "stSizeZ":0,
                "polki":[
                    {
                        "polkaSizeH":0,
                        "mesto":[
                            {
                                "mestoSizeW":0
                            }
                        ]
                    }
                ]
            }
        ]
    };
    
    
    
    function next(type){
        switch(type){
            case 'stelaj':
                createStelaji();
            break;
            case 'nextStelaj':
                createStelaji();
            break;
        }
    }
    
    function createStelaji(){
        var count = document.getElementById("countStelaj").value;
        
        newWareHouse.whName = document.getElementById("nameWH").value;
        newWareHouse.whSizeH = document.getElementById("whW").value;
        newWareHouse.whSizeW = document.getElementById("whH").value;
        newWareHouse.whSizeZ = document.getElementById("whZ").value;
        
        newWareHouse.stelaji.length = count;
        
        for (var i = 0; i < count; i++) {
            var stelajNum = i+1;
            var newDiv = document.createElement("div");
            newDiv.innerHTML += "<hr>";
            
            newDiv.innerHTML += "<h1>Стелаж №"+stelajNum+"</h1>";
            newDiv.innerHTML += "<h2>Размеры стелажа №"+stelajNum+"</h2>";
            newDiv.innerHTML += "Ширина<input id='"+i+"StelajW'>";
            newDiv.innerHTML += "Высота<input id='"+i+"StelajH'>";
            newDiv.innerHTML += "Глубина<input id='"+i+"StelajZ'>";
            newDiv.innerHTML += "<hr>";
            newDiv.innerHTML += "<h2>Количество полок</h2>";
            newDiv.innerHTML += "<input id='"+i+"Polok'>";
            newDiv.innerHTML += "<input type='button' value='Создать' onClick='countPolka("+i+")'>";
            newDiv.innerHTML += "<ul id='"+i+"divPolki'/>";
            newDiv.innerHTML += "<hr>";
            
            var my_div = document.getElementById("creatorWHpage");
            
            my_div.appendChild( newDiv );
            

        }
    }
    
    function countPolka(stelaj){
        var count = document.getElementById(stelaj+"Polok").value;
        var newDiv = document.createElement("div");
        newDiv.innerHTML += "<hr>";
        
        //Замолняем массив
        var countStelajey = document.getElementById("countStelaj").value;
        newWareHouse.stelaji[stelaj].polki.length = count;
        for(var i=0;i<countStelajey;i++){
            newWareHouse.stelaji[i].stSizeH = document.getElementById(i+"StelajH").value;
            newWareHouse.stelaji[i].stSizeW = document.getElementById(i+"StelajW").value;
            newWareHouse.stelaji[i].stSizeZ = document.getElementById(i+"StelajZ").value;
        }

        
        for (var i = 0; i < count; i++) {
            var polkaNum = i+1;
            
            newDiv.innerHTML += "<h1>Полка №"+polkaNum+"</h1>";
            newDiv.innerHTML += "<h2>Высота полки <input id='HP"+i+"Stelaj"+stelaj+"'></h2>";
            newDiv.innerHTML += "<h2>Количество мест хранения <input id='CountMesto"+i+"Stelaj"+stelaj+"'></h2>";
            newDiv.innerHTML += "<input type='button' value='Создать место' onClick='countMesta("+stelaj+","+i+")'>";
            
            newDiv.innerHTML += "<ul id='"+i+"divMesto'/>";
            newDiv.innerHTML += "<ul id='"+i+"divMestaStelaj"+stelaj+"'/>";
            newDiv.innerHTML += "<hr>";
            
            newWareHouse.stelaji[stelaj].polki[i].polkaSizeH = document.getElementById("HP"+i+"Stelaj"+stelaj).value;
        }
        
        newDiv.innerHTML += "<input type='button' value='Проверить' onClick='equalsHeightPolki("+stelaj+")'>";
        newDiv.innerHTML += "<hr>";
        var my_div = document.getElementById(stelaj+"divPolki");
        my_div.appendChild( newDiv );
    }                   
    
    
    function countMesta(stelaj,polka){
        var count = document.getElementById("CountMesto"+polka+"Stelaj"+stelaj).value;
        var newDiv = document.createElement("div");
        newDiv.innerHTML += "<hr>";
        
        //Заполняем массив
        var countPolok = document.getElementById(stelaj+"Polok").value;
        newWareHouse.stelaji[stelaj].polki[polka].mesto.length = count;
        for(var i=0;i<countPolok;i++){
            newWareHouse.stelaji[stelaj].polki[polka].mesto[i].mestoSizeW = document.getElementById("WM"+i+"Polka"+polka+"Stelaj"+stelaj).value;
        }
        
        for (var i = 0; i < count; i++) {
            var mestoNum = i+1;
            newDiv.innerHTML += "<h1>Место №"+mestoNum+"</h1>";
            newDiv.innerHTML += "<h2>Размер в ширину <input id='WM"+i+"Polka"+polka+"Stelaj"+stelaj+"'></h2>";
            newDiv.innerHTML +="<select name='typeMesto'' id='typeMesto''><option value='Ящик'>Ящик</option><option value='Место''>Место</option></select>";
            newDiv.innerHTML += "<hr>";
        }
        var my_div = document.getElementById(polka+"divMestaStelaj"+stelaj);
        my_div.appendChild( newDiv );
    }
     
    function equalsHeightPolki(stelaj){
        var countPolok = document.getElementById(stelaj+"Polok").value;
        var countStelaj = document.getElementById("countStelaj").value;
        var countMest;
        
        var stelajHeight = document.getElementById(stelaj+"StelajH").value;
        var stelajWidth = document.getElementById(stelaj+"StelajW").value;
        
        var sumHeight = 0;
        var sumWidthMesto = [];
        
        sumWidthMesto.length = countPolok;
        for(var s=0;s<sumWidthMesto.length;s++){
            sumWidthMesto[s] = 0;
        }
        
        for (var i = 0; i < countPolok; i++) {
            var input = document.getElementById("HP"+i+"Stelaj"+stelaj).value;
            sumHeight +=parseFloat(input);
            
            countMest = document.getElementById("CountMesto"+i+"Stelaj"+stelaj).value;
            for(var j=0;j<countMest;j++){
                var inputW = document.getElementById("WM"+j+"Polka"+i+"Stelaj"+stelaj).value;
                sumWidthMesto[i] += parseFloat(inputW);
            }
        }
        
        
        var debugDiv = document.getElementById("debug");
        
        debugDiv.innerHTML += "whName"+newWareHouse.whName;
        debugDiv.innerHTML += "whSizeH"+newWareHouse.whSizeH+"<hr>";
        debugDiv.innerHTML += "whSizeW"+newWareHouse.whSizeW+"<hr>";
        debugDiv.innerHTML += "whSizeZ"+newWareHouse.whSizeZ+"<hr>";
        for(var i=0;i<newWareHouse.stelaji.length;i++){
            debugDiv.innerHTML += "stSizeH"+newWareHouse.stelaji[i].stSizeH+"<hr>";
            debugDiv.innerHTML += "stSizeW"+newWareHouse.stelaji[i].stSizeW+"<hr>";
            debugDiv.innerHTML += "stSizeZ"+newWareHouse.stelaji[i].stSizeZ+"<hr>";
            for(var j=0;j<newWareHouse.stelaji[i].polki.length;j++){
                debugDiv.innerHTML += "polkaSizeH"+newWareHouse.stelaji[i].polki[j].polkaSizeH+"<hr>";
                for(var a=0;a<newWareHouse.stelaji[i].polki[j].mesto.length;a++){
                    debugDiv.innerHTML += "mestoSizeW"+newWareHouse.stelaji[i].polki[j].mesto[a].mestoSizeW+"<hr>";
                    
                }
            }
        }
        
        
        var succes = true;
        
        for(var a=0;a<sumWidthMesto.length;a++){
            debugDiv.innerHTML += sumWidthMesto[a]+"<hr>";  
            if(sumWidthMesto[a] != stelajWidth || stelajHeight!=sumHeight){
               succes = false;
            }
        }
        
        if(succes){
            alert("Всё збс, продолжай!");
        }else{
            alert("Размеры не совпадают!");
            return;
        }
        
        
        var newDiv = document.createElement("form");
        newDiv.innerHTML += "<input type='button' value='СОЗДАТЬ!' id='create'>";
        var my_div = document.getElementById("creatorWHpage");
        my_div.appendChild( newDiv );

    }
    
</script>

<?php
  
// PHP program to get IP address of client
$IP = $_SERVER['REMOTE_ADDR'];
  
// $IP stores the ip address of client
echo "Ваш IP: $IP";


?>