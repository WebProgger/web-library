function search(id) {

    /*$.ajax({
        url: '/modules/books.php',
        method: 'GET',
        dataType: 'html',
        data: {genre: id},
        success: function(data) {
            console.log('Запрос выполнен успешно!');
        }
    });*/

    window.location.href = "/books?idgenre="+id+"";

}
