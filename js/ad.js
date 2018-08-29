$(document).ready(function () {

    // $(".week_view_table tr td").each(function (k, v) {
    //     var myInputName = $(v).find("input").first().attr('name');
    //     console.log(myInputName);
    // });

    var counter = 0;
    $(".week_view_table tr").each(function (k, v) {
        if (counter % 2 == 1 && counter > 0) {
            $(v).find('td').find('textarea').each(function (a, b) {
                $(this).addClass('weekview-table-fill-duration');
            });
        }else{
            $(v).find('td').find('textarea').each(function (a, b) {
                $(this).addClass('weekview-table-fill-notes');
            });
        }
        counter++;
    });
});