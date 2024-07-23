jQuery(document).ready(function () {
    // hilangkan tombol cari
    $('#tombolCari').hide();

    // EVENT KETIKA KEYWORD DI TULISKAN
    $('#keyword').on('keyup', function () {
        // munculkan icon loading
        $('.loader').show();

        // ajax menggunakan load
        // $('#container').load('ajax/siswa.php?keyword=' + $('#keyword').val());

        // $.get()
        $.get('ajax/siswa.php?keyword=' + $('#keyword').val(), function(data) {

            $('#container').html(data);
            $('.loader').hide();

        })
    });

});