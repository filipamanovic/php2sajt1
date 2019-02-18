const BaseUrl = "http://localhost:8080";
$(document).ready(function () {
    $(".deleteKor").click(function () {
        var idKor = $(this).data('id');
        //alert(idKor);
        obj = {
            idKor: idKor,
            uspesno: true
        };
        $.ajax({
            method: "post",
            url: "views/korisnici/delete.php",
            data: obj,
            success: function (podaci) {
                $("#odgovor").html(podaci);
            },
            error: function (xhr, status, error) {
                console.log(xhr.status);
            }
        });
    });


    $("#popuniKorisnika").click(function () {
        //alert(idKor);
        var idKor = window.location.href.substr(window.location.href.lastIndexOf('=')+1);
        var obj = {
            idKor: idKor,
            uspesno2: true
        };
        $.ajax({
            method: "post",
            url: "modules/korisnici/update.php",
            data: obj,
            success: function (podaci) {
                console.log(podaci);
                $("#updIme").val(podaci.ime);
                $("#updPrezime").val(podaci.prezime);
                $("#updEmail").val(podaci.email);
                $("#updPass").val(podaci.password);
                $("#updGrad").val(podaci.grad);
                $("#updTel").val(podaci.kontakt);
                $("input[name='aktivan']").removeAttr('checked');
                if(podaci.aktivan == 1){
                    $("input[name='aktivan']").prop('checked', true);
                    $("input[name='aktivan']").val(podaci.aktivan);
                };
                $("#uloga").val(podaci.uloga_id);
                $("#hiddenID").val(podaci.id);
            },
            error: function (xhr, status, error) {
                console.log(xhr.status);
            }
        });
    });





});











