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
    let conversationId = $(this).parent().parent().parent().attr('data-id');
    let senderId = $(this).parent().parent().parent().attr('data-sender-id');
    $('.button-select-user-id[data-id="' + conversationId + '"]').trigger('click');
    $('.content-message-popup-parent[data-id="' + conversationId + '"]').remove();
    $('.button-select-user-id[data-id="' + senderId + '"]').trigger('click');
    $('.content-message-popup-parent[data-id="' + senderId + '"]').remove();
  });

  $(document).on('click', '.reply-message-on-toast', function (e) {
    let userSendId = $(this).parent().attr('data-id');
    let messageContent = $(this).parent().prev().val();
    if (!messageContent) {
      $.toast({
        heading: 'Error',
        text: 'Message reply is empty!',
        showHideTransition: 'fade',
        icon: 'error'
      })
    } else {
      let sendMessageUrl = window.location.protocol + '//' + window.location.host + '/chat/send-message'
      sendMessageByAjax(userSendId, sendMessageUrl, messageContent, true);
    }
  });

  $(document).on('click', '#toast-feedback', function (e) {
      $('#current-type-conversation').val(0);
  })
});
