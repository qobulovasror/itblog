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


// search
let searchSubmit = document.getElementById('searchSubmit');
    searchSubmit.addEventListener('click',function(e){
        e.preventDefault();
    })
