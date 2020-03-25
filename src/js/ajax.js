$(function(){
  const url = location.href;
  console.log('url:'+url);
if(url.indexOf('msg.php') != -1){
  function loadMsg(){
    const b_id = $('.js-addMsg').data('b_id'),
          u_id = $('.js-addMsg').data('u_id') || null,
          c_id = $('.js-addMsg').data('c_id') || null;
    $.ajax({
      type: 'GET',
      url: 'ajax.php',
      data: {
        func: 'load',
        b_id: b_id
      },
      dataType: 'json',
    }).done(function(data){
      $('.js-msg').html('');
      for(let i in data){
        console.log(data[i]);
        if((u_id != null &&data[i].u_id != null) || (c_id != null &&data[i].c_id != null)){
          $('.js-msg').append(
            '<div class="u-flex-reverse u-align-end u-mb_xl">'+
            '<div class="msg msg--right">'+ data[i].comment.replace(/\r?\n/g, '<br>') + '</div>'+
            '<span class="u-ml_m u-mr_m">'+ data[i].create_date.slice(0, -3) +'</span>'+
            '</div>'
          );
        }else{
          $('.js-msg').append(
            '<div class="u-flex u-align-end u-mb_xl">'+
            '<div class="msg msg--left">'+ data[i].comment.replace(/\r?\n/g, '<br>') + '</div>'+
            '<span class="u-ml_m u-mr_m">'+ data[i].create_date.slice(0, -3) +'</span>'+
            '</div>'
          );
        }
      }
    });
  };
  loadMsg();
  setInterval(function(){loadMsg()}, 30000);


$('.js-addMsg').on('click', function(){
  const u_id = $(this).data('u_id') || null,
        c_id = $(this).data('c_id') || null,
        comment = $(this).siblings('.comment').val(),
        b_id = $(this).data('b_id');
  console.log(comment);
  if(comment.length !== 0){
  $.ajax({
    type: 'GET',
    url: 'ajax.php',
    data: {
      func: u_id? 'userMsg': 'companyMsg',
      id: u_id? u_id: c_id,
      comment: comment,
      b_id: b_id
    },
    context: this,
  }).done(function(data){
    console.log($(this));
    $(this).siblings('.comment').val('');
    loadMsg();
  });
}
});
}
});
