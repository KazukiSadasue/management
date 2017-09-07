$(function() {
    $.ajax({
        type: "GET",
        url: "/admin/calendar/calendarAjax",
        data:
        {
            "year": $('#year').val(),
            "month": $('#month').val(),
        },
        success: function(users)
        {
            var old_user_id = $('#old_user_id').val();

            $('#user > option').remove();
            $('#user').append($('<option>').val("").text('ユーザー選択'));
            users.forEach(function(user, i) {
                if ( old_user_id == user['user_id'] ) {
                    $('#user').append($('<option>').val(user['user_id']).text(user['name']).prop('selected', true));
                } else {
                    $('#user').append($('<option>').val(user['user_id']).text(user['name']));
                }
            });
        },
        error: function(XMLHttpRequest,textStatus,errorThrown)
        {
            alert('エラーです！');
        }
    });

    $('#send').click(function() {
        var id = $('#user').val();
        if ( id == "" ) {
            window.location.href = '/admin/calendar';
        }
        else {
            var year = $('#year').val();
            var month = $('#month').val();
            window.location.href = '/admin/calendar/' + id + '/' + year + '/' + month;
        }
    });

    $('#year').change(function(){
        $.ajax({
            type: "GET",
            url: "/admin/calendar/calendarAjax",
            data:
            {
                "year": $('#year').val(),
                "month": $('#month').val(),
            },
            success: function(users)
            {
                var old_user_id = $('#old_user_id').val();

                $('#user > option').remove();
                $('#user').append($('<option>').val("").text('ユーザー選択'));
                users.forEach(function(user, i) {
                    if ( old_user_id == user['user_id'] ) {
                        $('#user').append($('<option>').val(user['user_id']).text(user['name']).prop('selected', true));
                    } else {
                        $('#user').append($('<option>').val(user['user_id']).text(user['name']));
                    }
                });
            },
            error: function(XMLHttpRequest,textStatus,errorThrown)
            {
                alert('エラーです！');
            }
        });
    });
    
    $('#month').change(function(){
        $.ajax({
            type: "GET",
            url: "/admin/calendar/calendarAjax",
            data:
            {
                "year": $('#year').val(),
                "month": $('#month').val(),
            },
            success: function(users)
            {
                var old_user_id = $('#old_user_id').val();

                $('#user > option').remove();
                $('#user').append($('<option>').val("").text('ユーザー選択'));
                users.forEach(function(user, i) {
                    if ( old_user_id == user['user_id'] ) {
                        $('#user').append($('<option>').val(user['user_id']).text(user['name']).prop('selected', true));
                    } else {
                        $('#user').append($('<option>').val(user['user_id']).text(user['name']));
                    }
                });
            },
            error: function(XMLHttpRequest,textStatus,errorThrown)
            {
                alert('エラーです！');
            }
        });
    });
});
