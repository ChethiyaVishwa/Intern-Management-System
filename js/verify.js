const otp = document.querySelectorAll('.otp_field');

//focus on first input
otp[0].focus();

otp.forEach((field, index) =>{
    field.addEventListener('keydown', (e) => {
        if (e.key >= 0 && e.key <=9) {
            otp[index].value = "";
            setTimeout(() => {
                otp[index+1].focus();            
            }, 4);
        }
        else if(e.key === 'Backspace'){
            setTimeout(() => {
                otp[index+1].focus();
            }, 4);

        }
    });
});


const form = document.querySelector('.form form'),
submitbtn = form.querySelector('.submit .button'),
errortxt = form.querySelector('.error-text');

form.onsubmit = (e) => {
    e.preventDefault();
}

submitbtn.onclick = () =>{
    // start ajax

    let xhr = new XMLHttpRequest(); //create xml object
    xhr.open("POST","./Php/otp.php" , true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status == 200){
                let data = xhr.response;
                if(data == "success"){
                    location.href = "./form.php"
                }
                else{
                    errortxt.textContent = data;
                    errortxt.style.display = "block";
                }
            }               
        }
    }

    // send data through ajax to php
    let formData = new FormData(form); //creating new object form form data
    xhr.send(formData); //sending data to php
}