const button=document.querySelector('#button')
let x=document.querySelectorAll('.checkbox')
let r=document.querySelectorAll('.radio')
let y=document.querySelector('#y')
const req=new XMLHttpRequest()
let x0
let y0
let R0
let Url="http://localhost:4000/"
let warning=""
let B=false

function connect(Url){
    let url = new URL(Url+"?x="+x0.name+"&y="+y0+"&R="+R0.value)
    req.open("GET",url)
    req.send()
    req.onload=()=>document.write(req.response)
    req.onerror=()=>alert("Сервер недоступен")
}

function checkX(x){
    let i=0
    for (let x1 of x) {
        if(x1.checked){
            i++
            x0=x1
        }
    }
    if(i!==1){
        warning+='Выберите один Х \n'
        B=true
    }
}

function checkY(y){
    if( y.value===''|| isNaN(Number(y.value)) || y.value>3 || y.value<-5) {
        warning+='Введите y={-5,...,3}\n'
        B=true
    } else y0=y.value
}

function checkR(r){
    let b=false;
    for (let r1 of r){
        if(r1.checked){
            b=true
            R0=r1
        }
    }
    if(!b){
        warning+='Выберите R\n'
        B=true
    }
}

button.onclick= ()=>{
    checkX(x)
    checkY(y)
    checkR(r)
    if(B){
        alert(warning)
        B=false
    }
    else connect(Url)
    warning=""
}
