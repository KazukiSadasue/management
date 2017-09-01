$(function()
{
    $('#send').click(function()
    {
        var year = $('#year').val();
        var month = $('#month').val();
        window.location.href = '/user/calendar' + '/' + year + '/' + month;
    });
});