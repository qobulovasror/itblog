        let name1 = document.getElementById('name'),
    email = document.getElementById('email'),
    login = document.getElementById('login'),
    parol = document.getElementById('parol'),
    reparol = document.getElementById('reparol');

// target alert
let alert1 = document.getElementById('alert');

// Submit function
let btnRegis = document.getElementById('regis');
btnRegis.addEventListener('click',function(e){

    // name
    if( name1.value.length < 4){
        e.preventDefault();
        alert1.innerHTML = "Familiya va Ism xato kiritilgan";
        alertBlock(name1); 
    }

    // email
    emailTest =  /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/ ;
    if( ! emailTest.test(email.value) ){
        e.preventDefault();
        alert1.innerHTML = "Email xato";
        alertBlock(email); 
    }

    // login
    if( login.value.length < 4 || login.value[0]== Number){
        e.preventDefault();
        alert1.innerHTML = "Login  xato";
        alertBlock(login); 
    }

    let loginAdmin = /^(Admin+[A-Za-z0-9])+$/;
    // login admin
    if (login.value =="Admin" || login.value =="admin" ) {
        if (loginAdmin.test(login.value) ) {
            e.preventDefault();
            alert1.innerHTML = "Login  xato";
            alertBlock(login);
        }
    }
    
    // parol
    if(parol.value.length < 4 || reparol.value.length < 4){
        e.preventDefault();
        alert1.innerHTML = "Parol  xato";
        alertBlock(parol);
        alertBlock(reparol);
    }else{
        if(parol.value !== reparol.value){
            e.preventDefault();
            alert1.innerHTML = "Birinchi va ikkinchi parollar mos emas";
            alertBlock(parol);
            alertBlock(reparol);
        }
    }
    
})


// Alert window 
function alertBlock(element) {
    element.style.border = "2px solid red";
    alert1.style.display = "block"; 
    setTimeout(() => {
        alert1.style.display = "none";
    }, 4000);
}

// keyup
name1.addEventListener('keyup',function(e) {
    if(e.target.value.length < 4){
        e.target.style.border = "2px solid red";
    }
    else{
      if(e.target.value.length < 6){
        e.target.style.border = "2px solid yellow";
      }else{
        e.target.style.border = "2px solid green";
      }
    }
})
          login.addEventListener('keyup',function(e) {
              if(e.target.value.length < 4){
                  e.target.style.border = "2px solid red";
              }else{
                  if(e.target.value.length < 6){
                      e.target.style.border = "2px solid yellow";
                  }else{
                      e.target.style.border = "2px solid green";
                  }    }
          })
          parol.addEventListener('keyup',function(e) {
              if(e.target.value.length < 4){
                  e.target.style.border = "2px solid red";
              }else{
                  if(e.target.value.length < 6){
                      e.target.style.border = "2px solid yellow";
                  }else e.target.style.border = "2px solid green"; 
              }
          })
          reparol.addEventListener('keyup',function(e) {
              if(e.target.value !== parol.value){
                  e.target.style.border = "2px solid red";
              }else{
                  e.target.style.border = "2px solid green";
              }
          })