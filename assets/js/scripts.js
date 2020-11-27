'use strict';
var mySwiper = new Swiper('.swiper-container', {
  // Optional parameters
  loop: true,
  autoplay: {
    delay: 5000,
  },

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },
});

let menuToggle = $('.header-menu-toggle');
menuToggle.on('click', function(event){
  event.preventDefault();
  $('.header-nav').slideToggle(200);
});

let contactsForm = $('.contacts-form');
contactsForm.on('submit', function (event) {
  event.preventDefault();
  // var userEmail = $(this).find('input[type=email]');
  // обращаемся к отправляемой форме, создаем объект
  // в этой formData есть все поля - имя,телефон
  var formData = new FormData(this);
// обращаемся к этой formData и добавляем туда action,в котором contacts_form
formData.append('action', 'contacts_form');
  $.ajax ({
    type: "POST",
    // форма отправляется в этот файлик, а потом в functions.php
    url: adminAjax.url,
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      console.log('Ответ сервера: ' + response);
    }
  });
});