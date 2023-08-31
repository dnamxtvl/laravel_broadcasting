import twemojiParser from 'twemoji-parser';
document.addEventListener('DOMContentLoaded', function () {
    const messageInput = document.getElementById('messageInput');
    const emojiButton = document.getElementById('emojiButton');

    emojiButton.addEventListener('click', function () {
        const emojiPicker = new EmojiPicker({
            onSelect: function (emoji) {
                const emojiHtml = twemojiParser.parse(emoji);
                messageInput.value += emojiHtml;
                emojiPicker.hidePicker();
            },
        });

        emojiPicker.showPicker(emojiButton);
    });
});
