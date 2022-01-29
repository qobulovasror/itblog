let search = document.getElementById('search'),
    searchWin = document.getElementById('searchWin'),
    searchCancel = document.getElementById('searchCancel'),
    searchKey = document.getElementById('searchKey');
search.addEventListener('click',function(){
    searchWin.style.top ="-22px";
})
searchCancel.addEventListener('click',function(){
    searchWin.style.top ="-100px";
})

let blog = document.querySelector('.blog');
    blog.addEventListener('click',function(){
        searchWin.style.top ="-100px";
    })




// respon menu
let resmenuwin = document.getElementById('resmenuwin'),
    menucancel = document.getElementById('menucancel'),
    resMenu = document.getElementById('resMenu');

resMenu.addEventListener('click',()=>{
    resmenuwin.style.left = "0";
})
menucancel.addEventListener('click',function(){
    resmenuwin.style.left = "-110%";
})