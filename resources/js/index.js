let eye = document.querySelector('.unit');
eye.addEventListener('click', (e)=>{
    if(eye.innerText === 'visibility_off'){
        eye.innerText = 'visibility';
        document.querySelector('.pass').type = 'text';
    }else{
        eye.innerText = 'visibility_off';
        document.querySelector('.pass').type = 'password';
    }
})
