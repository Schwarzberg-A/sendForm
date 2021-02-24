'use strict';

  var selector = document.querySelector('[type="tel"]');
  var im = new Inputmask("+7 (999) 9999999");
  im.mask(selector);
  
  const form = document.querySelector('form');
  const formWrapper = document.querySelector('.form-wrapper');
  form.addEventListener('submit', formSend);
  
  async function formSend(ev) {
    ev.preventDefault();
  
    let error = formValidate(form);
    let formData =  new FormData(form);
  
    if (error === 0) {
      formWrapper.classList.add('_sending');
      let response = await fetch('../mail.php', {
        method: 'POST',
        body:  formData,
        keepalive: true
      });

      if (response.ok) {
      	let result = await response.json();
        alert(result.message);
        formWrapper.classList.remove('_sending');
        form.reset();	
      } else {
        alert('ошибка отправки формы');
        formWrapper.classList.remove('_sending');
      }
    } else {
      alert('заполните обязательные поля');
    }
  }
  
  function formValidate() {
    let err = 0;
    let formReq = document.querySelectorAll('._req');
    for (let i = 0; i < formReq.length; i++) {
      let input = formReq[i];
      formRemoveError(input);
      if (input.classList.contains('_email')) {
        if (emailTest(input)) {
          formAddError(input);
          err++;
        }
      } else if (input.getAttribute('type') === 'checkbox' && !input.checked) {
        formAddError(input);
        err++;
      } else {
        if (input.value === '') {
          formAddError(input);
          err++;
        }
      }
    }
    return err;
  }
  
  function formAddError(input) {
    input.parentElement.classList.add('_error');
    input.classList.add('_error');
  }
  
  function formRemoveError(input) {
    input.parentElement.classList.remove('_error');
    input.classList.remove('_error');
  }
  
  function emailTest(input) {
    return !/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/.test(input.value);
  }



