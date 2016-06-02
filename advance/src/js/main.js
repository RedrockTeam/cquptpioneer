// 轮播插件
import './unslider-min.js';
$(document).ready(function() {
    $('.slide-banner').unslider({
        autoplay: true,
        arrows: {
            prev: '',
            next: ''
        }
    });
});
