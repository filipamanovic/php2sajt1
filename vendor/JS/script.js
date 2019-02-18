const BASE_URL = "http://localhost:8080/php2sajt1";
$(document).ready(function () {
    $('#nameReg').hide();
    $('#lastNReg').hide();
    $('#emailReg').hide();
    $('#passReg').hide();
    $('#telReg').hide();
    $('#cityReg').hide();


    // Registracija korisnika //
    $('#btnReg').click(function () {
        var ime = $('#firstName').val();
        var prezime = $('#lastName').val();
        var email = $('#email').val();
        var pass = $('#password').val();
        var tel = $('#tel').val();
        var city = $('#grad').val();

        var regIme = /^[A-ZŽĐŠĆČ][a-zžđšćč]{1,19}$/;
        var regPrezime = /^[A-ZŽĐŠĆČ][a-zžđšćč]{1,19}(\s[A-ZŽĐŠĆČ][a-zžđšćč]{1,19})*$/;
        var regPassord = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
        var regEmail = /^.{1,30}\@.{2,10}\..{1,5}$/;
        var regTel = /^[+][\d]{0,3}\/[\d]{4,7}\-[\d]{3}$/;

        var nizGreske = [];

        if (!regPrezime.test(city)) {
            $('#cityReg').show();
            $('#cityReg').css('border', '1px solid crimson');
            nizGreske.push('City format bad.');
        } else {
            $('#cityReg').hide();
            $('#cityReg').css('border', '');
        }

        if (!regIme.test(ime)) {
            $('#nameReg').show();
            $('#firstName').css('border', '1px solid crimson');
            nizGreske.push('First name incorect!');
        } else {
            $('#nameReg').hide();
            $('#firstName').css('border', '');
        }

        if (!regPrezime.test(prezime)) {
            $('#lastNReg').show();
            $('#lastName').css('border', '1px solid crimson');
            nizGreske.push('Last name incorect!');
        } else {
            $('#lastNReg').hide();
            $('#lastName').css('border', '');
        }

        if (!regEmail.test(email)) {
            $('#emailReg').show();
            $('#email').css('border', '1px solid crimson');
            nizGreske.push('Email incorect!');
        } else {
            $('#emailReg').hide();
            $('#email').css('border', '');
        }

        if (!regPassord.test(pass)){
            $('#passReg').show();
            $('#password').css('border', '1px solid crimson');
            nizGreske.push('Password incorect!');
        } else {
            $('#passReg').hide();
            $('#password').css('border', '');
        }

        if (!regTel.test(tel)) {
            $('#telReg').show();
            $('#tel').css('border', '1px solid crimson');
            nizGreske.push('Concat tel incorect!');
        } else {
            $('#telReg').hide();
            $('#tel').css('border', '');
        }

        if (nizGreske.length == 0){
            var data = {
                'ime' : ime,
                'prezime' : prezime,
                'email' : email,
                'pass' : pass,
                'tel' : tel,
                'city': city,
                'success' : true
            };
            $.ajax({
                method : 'post',
                url : 'modules/register.php',
                data : data,
                success : function (data) {
                    $("#odgovorBaze").html("<h3>Successful registration, please activate an account on your email.</h3>");
                },
                error : function (xhr, status, error) {
                    $("#odgovorBaze").html("<p>Successful registration, please activate an account on your email.</p>");
                    switch(xhr.status) {
                        case 404 :
                            poruka = "Stranica nije pronadjena.";
                            break;
                        case 409:
                            poruka = "Username ili email vec postoji.";
                            break;
                        case 422:
                            poruka = "Podaci nisu validni.";
                            console.log(xhr.responseText);
                            break;
                        case 500:
                            poruka = "Greska.";
                            break;
                    }
                }
            })
        }
    });

    //Brisanje proizvoda
    $('.deleteAd').click(function () {
       var potvrda = confirm('Are you sure you want to delete that product?');
       if (potvrda == true){
           var id = $(this).data('id');
           var data = {
               'id' : id,
               'success' : true
           };

           $.ajax({
              url : 'modules/deleteAd.php',
              method : 'post',
              data : data,
              success : function (data) {
                  alert(data);
              },
              error : function (xhr, status, error) {
                  alert(xhr.getStats());
              }
           });
       }
    });


    //Update proizvoda
    $('.updateAd').click(function (e) {
        e.preventDefault();
        var proizvodId = $(this).data('id');
        var data = {
            'proizvodId': proizvodId,
            'success': true
        };
        $.ajax({
           method: 'post',
           url: 'modules/getDataForUpdate.php',
           data: data,
           success: function (data) {
                $('#upName').val(data['naziv']);
                $('#upPrice').val(data['cena']);
                $('#upDesc').val(data['opis']);
                $('#upProizvod').val(proizvodId);
           },
           error: function (xhr, status, error) {
               console.log(xhr.status);
           }
        });
    });

    //Sortiranje proizvoda
    $("#btnSort").click(function () {
        var kategorija = document.getElementById('selectKat');
        var selektovanoKat = document.getElementById('selectKat').selectedIndex;
        var kat = kategorija.options[selektovanoKat].value;
        // console.log(kat);

        var proizvodjac = document.getElementById('selectPro');
        var selektovanoPro = document.getElementById('selectPro').selectedIndex;
        var pro = proizvodjac.options[selektovanoPro].value;
        // console.log(pro);

        var sortMin = $('#sortMin').val();
        var sortMax = $('#sortMax').val();

        if(sortMin == ''){
            sortMin = 'null';
        }
        if(sortMax == ''){
            sortMax = 'null';
        }

        // console.log(sortMin);

        var data = {
            'kat' : kat,
            'pro' : pro,
            'min': sortMin,
            'max': sortMax,
            'successSort' : true
        };

        $.ajax({
           url: 'modules/sortProizvodi.php',
           method: 'post',
           data: data,
           success: function (data) {

           }
        });
        window.location.replace(BASE_URL);

    });
});