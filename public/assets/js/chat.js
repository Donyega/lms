document.addEventListener("DOMContentLoaded", function (e) {
    document.querySelector("#type-area").addEventListener("keydown", function (e) {
        if (e.key === 'Enter') {
            let input = this.value;
            if (input !== "") {
                sendMessage(input)

                this.value = ""
            }
        }
    });
});


/*
    handel send message function
 */
function sendMessage(message) {
    $('.formbalas').remove()
    // let url ='/pembelajaran/topikdiskusi/diskusi/store'
    // let token = $("input[name=_token]").val();
    let idtopik = $('#idtopik').val()
    let iddiskusi = $('#iddiskusi').val()
    $.ajax({
        type:"get",
        url: '/pembelajaran/topikdiskusi/diskusi/store',
        dataType: 'json',
        data: {pesan : message, idtopik : idtopik, iddiskusi:iddiskusi, _token: '{{CSRF_TOKEN()}}'},
        success: function(data){
            idtopik = 1
          let nama = $('#namachat').val()
          let foto = $('#fotochat').val()
          let html = '<div class="chat"><div class="chat-avatar"><div class="avatar-lecture"><img src="'+foto+'" alt="avatar" width="100%" /></div></div><div class="chat-body">';

          if(data[0].iddiskusi != null){
            let namabalas ='';
            if(data[1].user.role == 2){
                namabalas = data[1].user.pegawai.nama;
            }
            html += '<div class="chat-content alert-dark"><small class="text-right">'+namabalas+'</small><p><b>'+data[1].diskusi+'</b></p></div>';
          }

          html +='<div class="chat-content"><small class="text-right">'+nama+'</small><p>'+message+'</p><button class="btn btn-sm balas2 text-warning" style="margin-left:60%;" value='+data[0].id+'>Balas</button></div></div></div>';

          var chatBody = document.querySelector("#chat-area");
              chatBody.insertAdjacentHTML("beforeend", html);
              chatBody.scrollTo({ left: 0, top: chatBody.scrollHeight, behavior: "smooth" });
              $('.belum').hide()


              $('.balas2').click(function(){
                $('.formbalas').remove()
                iddiskusi = $(this).val();
                $('#iddiskusi').val(iddiskusi)
                $.get('/getbalas/'+iddiskusi, function(data){
                  var balas ='<div class="card alert-dark formbalas" style="margin-bottom:-40px;"><div class="chat"><div class="row"><div class="col-md-10"><div class="chat-body"><div class="chat-content" style="padding:20px;"><small class="text-right text-primary">'+data[0]+'</small><p>'+data[1].diskusi+'</p></div></div></div><div class="col-md-2"><button id="batalbalas" type="button" class="close p-2 batalbalas"><span aria-hidden="true"><b>&times;</b></span></button></div></div></div></div>';
          
                $('.balasdisini').before(balas)
                $('.batalbalas').click(function(){
                  $('.formbalas').remove()
                })
                })
              })

          $('#iddiskusi').val('')

        },
        error:function(data){
          console.log(data);
          alert('TERDAPAT KESALAHAN, SILAHKAN MENCOBA KEMBALI')
        }
      });
}

/*
    handel to left message from friend
 */
function handelLeftMessage(data) {
    $('.belum').hide()
    let html ='<div class="chat chat-left"><div class="chat-avatar"><div class="avatar-lecture"><img src="'+data.foto+'" alt="avatar" width="100%" /></div></div><div class="chat-body">';

    if(data.diskusi.iddiskusi != null){
        let namabalas ='';
            if(data.balas.user.role == 2){
                namabalas = data.balas.user.pegawai.nama;
            }
        html+='<div class="chat-content alert-dark"><small>'+namabalas+'</small><p><b>'+data.balas.diskusi+'</b></p></div>';
    }

    html+='<div class="chat-content"><small>'+data.nama+'</small><p><b>'+data.pesan+'</b></p><button class="btn btn-sm balas3 text-warning" style="margin-left:60%;" value='+data.diskusi.id+'>Balas</button></div></div></div>';

    var chatBody = document.querySelector("#chat-area");
        chatBody.insertAdjacentHTML("beforeend", html);
        chatBody.scrollTo({ left: 0, top: chatBody.scrollHeight, behavior: "smooth" });


        $('.balas3').click(function(){
            $('.formbalas').remove()
            iddiskusi = $(this).val();
            $('#iddiskusi').val(iddiskusi)
            $.get('/getbalas/'+iddiskusi, function(datas){
              var balas ='<div class="card alert-dark formbalas" style="margin-bottom:-40px;"><div class="chat"><div class="row"><div class="col-md-10"><div class="chat-body"><div class="chat-content" style="padding:20px;"><small class="text-right text-primary">'+datas[0]+'</small><p>'+datas[1].diskusi+'</p></div></div></div><div class="col-md-2"><button id="batalbalas" type="button" class="close p-2 batalbalas"><span aria-hidden="true"><b>&times;</b></span></button></div></div></div></div>';
      
            $('.balasdisini').before(balas)
            $('.batalbalas').click(function(){
              $('.formbalas').remove()
            })
            })
          })
}
