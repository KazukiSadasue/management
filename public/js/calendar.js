$(function()
{
    $('#send').click(function()
    {
        var year = $('#year').val();
        var month = $('#month').val();
        window.location.href = '/calendar' + '/' + year + '/' + month;
    });
});