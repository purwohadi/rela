(function () {
  'use strict'

  window.addEventListener('load', () => {
    reloadCaptcha()
    getPengumuman()
    const seekBtn = document.getElementById("seek-btn")
    seekBtn.addEventListener('click', () => {
      Promise.resolve(seekBtn.getAttribute('data-state'))
        .then(state => {
          return (state === 'off')
            ? { type: 'text', state: 'on', icon: 'fa-eye-slash' }
            : { type: 'password', state: 'off', icon: 'fa-eye' }
        })
        .then(result => {
          let target = document.getElementById('password')
          target.setAttribute('type', result.type)
          seekBtn.setAttribute('data-state', result.state)
          seekBtn.innerHTML = `<i class="fal ${ result.icon } fs-xl"></i>`
        })
    })

    $('#panel-container-information').slimScroll({
      position: 'right',
      height: '440px',
      railVisible: false,
      alwaysVisible: false
    });

    const forms = document.getElementsByClassName('needs-validation')
    Array.prototype.filter.call(forms, (form) => {
      form.addEventListener('submit', (event) => {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });

    document.getElementById("reload-captcha").onclick = function () {
      reloadCaptcha()
    }

    function reloadCaptcha() {
      let rand = Math.random()
      var xhr = new XMLHttpRequest();
      var url = "reload-captcha/?=" + rand;

      xhr.onloadstart = function () {
        document.getElementById("captcha-img").innerHTML = "Loading...";
      }

      xhr.onerror = function () {
        alert("Gagal reload captcha");
      };

      xhr.onloadend = function () {
        if (this.responseText !== "") {
          document.getElementById("captcha-img").src = url;
          document.getElementById("read-captcha").innerHTML = 'Klik Captcha';
        }
      };

      xhr.open("GET", url, true);
      xhr.send();
    }

    function getPengumuman() {
      let page = 15
      let page_banner = 1
      $.ajax({
          url: APP_URL + "/pengumuman",
          type: 'GET',
          cache: false,
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data:{
              current_page: page,
              current_page_banner: page_banner,
              sort_by: ['dt_updated_at', 'i_id'],
              sort_desc: 'desc'
          },
          success: function(response){
            $('#pengumuman_box').html('');
            $('#pengumuman_banner_box').html('');
            $('#pengumuman_box').html(response[0]);
            $('#pengumuman_banner_box').html(response[1]);

            $('#pengumuman_banner').modal('show');
          }
      });
    }

    document.getElementById("read-captcha").onclick = function () {
      var xhr = new XMLHttpRequest();
      var url = "read-captcha";

      xhr.onerror = function () {
        alert("Gagal reload captcha");
      };

      xhr.onloadend = function () {
        if (this.responseText !== "") {
          var result = JSON.parse(this.responseText);
          document.getElementById("read-captcha").innerHTML = 'Captchanya adalah ' + result.captcha;
        }
      };

      xhr.open("GET", url, true);
      xhr.send();
    }
  }, false)
})()
