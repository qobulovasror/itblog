let search = document.getElementById('search'),
    searchWin = document.getElementById('searchWin'),
    searchCancel = document.getElementById('searchCancel');
search.addEventListener('click',function(){
    searchWin.style.top ="-22px";
})
searchCancel.addEventListener('click',function(){
    searchWin.style.top ="-100px";
})


