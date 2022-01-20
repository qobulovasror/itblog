let llogin = document.getElementById("llogin"),
    lparol = document.getElementById("lparol");

let alert2 = document.getElementById("alert");
let loginIn = document.getElementById("loginIn");

loginIn.addEventListener("click", function (e) {
  if (llogin.value == "" || llogin.value.length < 4) {
    e.preventDefault();
    alert2.innerHTML = "Login xato";
    alertBlock(llogin);
  }
  if (lparol.value == "" || lparol.value.length < 4 ) {
    e.preventDefault();
    alert2.innerHTML = "Parol xato";
    alertBlock(lparol);
  }
});

function alertBlock(element) {
  element.style.border = "2px solid red";
  alert2.style.display = "block";
  setTimeout(() => {
    alert2.style.display = "none";
  }, 4000);
}
alert2.addEventListener("click", function () {
  this.style.display = "none";
});

llogin.addEventListener('keyup',function(e) {
  if(e.target.value.length < 3){
      e.target.style.border = "2px solid red";
  }else{
      if(e.target.value.length < 5){
          e.target.style.border = "2px solid yellow";
      }else{
          e.target.style.border = "2px solid green";
      }
  }
})
lparol.addEventListener('keyup',function(e) {
  if(e.target.value.length < 4){
      e.target.style.border = "2px solid red";
  }else{
      if(e.target.value.length < 7){
          e.target.style.border = "2px solid yellow";
      }else{
          e.target.style.border = "2px solid green";
      }
  }
})