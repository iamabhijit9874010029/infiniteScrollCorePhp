<!DOCTYPE html>
<html>

<head>
    <title>Infinite Scroll</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .post {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <div id="posts"></div>
    <div id="loader" style="text-align:center;">Loading...</div>

    <script>
        let limit = 10;
        let start = 0;
        let action = 'inactive';

        function load_posts(limit, start) {
            $.ajax({
                url: "fetch_posts.php",
                method: "POST",
                data: {
                    limit: limit,
                    start: start
                },
                success: function(data) {
                    if (data.trim() === '') {
                        $('#loader').html("No more posts");
                        action = 'active';
                    } else {
                        $('#posts').append(data);
                        $('#loader').html("Loading...");
                        action = 'inactive';
                    }
                }
            });
        }

        if (action === 'inactive') {
            action = 'active';
            load_posts(limit, start);
        }

        // $(window).scroll(function() {
        //     if ($(window).scrollTop() + $(window).height() > $("#posts").height() && action === 'inactive') {
        //         action = 'active';
        //         start += limit;
        //         setTimeout(function() {
        //             load_posts(limit, start);
        //         }, 1000);
        //     }
        // });

        let debounceTimer;
        $(window).scroll(function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 300 && action === 'inactive') {
                    action = 'active';
                    start += limit;
                    load_posts(limit, start);
                }
            }, 200); // adjust delay if needed
        });
    </script>
</body>

</html>