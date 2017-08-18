$(function()
{
    $('#send').click(function()
    {
        var year = $('#year').val();
        var month = $('#month').val();
        alert( year + '年' + month + '月' );
        window.location.href = '/' + year + '/' + month;
    });
});