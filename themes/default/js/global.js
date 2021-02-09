var block1 = '.form-add-type1-change';
var block2 = '.form-add-type2-change';

$('#btn_1').on('click', function() {
    if($(block1).hasClass('hidden')) {
        $(block1).removeClass('hidden');
        $(block1).addClass('visible');
    } else if($(block1).hasClass('visible')) {
        $(block1).removeClass('visible');
        $(block1).addClass('hidden');       
    }
});

$('#btn_2').on('click', function() {
    if($(block2).hasClass('hidden')) {
        $(block2).removeClass('hidden');
        $(block2).addClass('visible');
    } else if($(block2).hasClass('visible')) {
        $(block2).removeClass('visible');
        $(block2).addClass('hidden');       
    }
});