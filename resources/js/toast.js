$(document).ready(function () {
  $(document).on('click', '.toast-close', function(e) {
    $(this).parent().parent().parent().remove();
  });

  $(document).on('click', '.toast-minimize', function(e) {
    $(this).prev().removeClass('hidden');
    $(this).addClass('hidden');
    $(this).parent().parent().parent().find('.content-popup-message').addClass('hidden');
  });

  $(document).on('click', '.toast-maximize', function (e) {
    $(this).next().removeClass('hidden');
    $(this).addClass('hidden');
    $(this).parent().parent().parent().find('.content-popup-message').removeClass('hidden');
  });

  $(document).on('click', '.redirect-detail-message', function (e) {
    var userSendId = $(this).parent().parent().parent().attr('data-id');
    console.log(userSendId);
    $('.button-select-user-id[data-id="' + userSendId + '"]').trigger('click');
    $('.content-message-popup-parent[data-id="' + userSendId + '"]').remove();
  });

  $(document).on('click', '.reply-message-on-toast', function (e) {
    var userSendId = $(this).parent().attr('data-id');
    var messageContent = $(this).parent().prev().val();
    if (!messageContent) {
      $.toast({
        heading: 'Error',
        text: 'Message reply is empty!',
        showHideTransition: 'fade',
        icon: 'error'
      })
    } else {
      var sendMessageUrl = window.location.protocol + '//' + window.location.host + '/admin/chats/send-message-to-user'
      sendMessageByAjax(userSendId, sendMessageUrl, messageContent, true);
    }
  });
});

