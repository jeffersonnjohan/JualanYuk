var edit = document.getElementById("edit");
var centang = document.getElementById("centang");
var centangKosong = document.getElementById("centangKosong");
var sampah = document.getElementById("sampah");
var namaAwal = document.getElementById("namaAwal");
var nama = document.getElementById("nama");
var kotak1 = document.getElementById("kotak1");
var kotak2 = document.getElementById("kotak2");

function muncul(){
    centangKosong.classList.toggle("displayNone")
    edit.classList.toggle("displayNone")
    sampah.classList.toggle("displayNone")
}

edit.addEventListener('click', muncul)
centang.addEventListener('click', muncul)

centangKosong.addEventListener('mouseenter', function(){
    centang.classList.toggle("displayNone")
    centangKosong.classList.toggle("displayNone")
})

centangKosong.addEventListener('mouseleave', function(){
    centang.classList.toggle("displayNone")
    centangKosong.classList.toggle("displayNone")
})


// function clickMe() {
//     var text = document.getElementById("popup");
//     text.classList.toggle("hide");
//     text.classList.toggle("show");
// }

edit.addEventListener('click', function(){
    namaAwal.classList.toggle("displayNone");
    nama.classList.toggle("displayNone");
    nama.disabled=false;
})

centang.addEventListener('click', function(){
    namaAwal.classList.toggle("displayNone");
    nama.classList.toggle("displayNone");
    nama.disabled=true;
})


kotak1.addEventListener('mouseenter', function(){
    console.log("halo")
    kotak1.classList.toggle("displayNone");
    kotak2.classList.toggle("displayNone");
})

kotak1.addEventListener('mouseleave', function(){
    kotak1.classList.toggle("displayNone");
    kotak2.classList.toggle("displayNone");
})