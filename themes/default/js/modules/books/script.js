var star;
var id;

function handler(elem) {
    star = elem;
    if(star.hasAttribute('starid')) { id = star.getAttribute('starid'); }
    if($(star).hasClass("fa-star-o")) {
        setFavorite(id);
    } else {
        unsetFavorite(id);
    }
}

function setFavorite(id) {
    $.ajax({
        url: '/ajax/books',
        method: 'POST',
        data: { method: "set", id_star: id },
    }).done(function() {
        star.classList.remove("fa-star-o");
        star.classList.add("fa-star");
    });
}

function unsetFavorite(id) {
    $.ajax({
        url: '/ajax/books',
        method: 'POST',
        data: { method: "unset", id_star: id },
    }).done(function() {
        star.classList.remove("fa-star");
        star.classList.add("fa-star-o");
    });
}