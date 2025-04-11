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
        //slower way to get the last id and limit
        // let limit = 10;
        // let start = 0;
        // let action = 'inactive';

        // function load_posts(limit, start) {
        //     $.ajax({
        //         url: "fetch_posts.php",
        //         method: "POST",
        //         data: {
        //             limit: limit,
        //             start: start
        //         },
        //         success: function(data) {
        //             if (data.trim() === '') {
        //                 $('#loader').html("No more posts");
        //                 action = 'active';
        //             } else {
        //                 $('#posts').append(data);
        //                 $('#loader').html("Loading...");
        //                 action = 'inactive';
        //             }
        //         }
        //     });
        // }

        // if (action === 'inactive') {
        //     action = 'active';
        //     load_posts(limit, start);
        // }

        // $(window).scroll(function() {
        //   if ($(window).scrollTop() + $(window).height() > $("#posts").height() && action === 'inactive') {
        //     action = 'active';
        //     start += limit;
        //     setTimeout(function() {
        //       load_posts(limit, start);
        //     }, 1000);
        //   }
        // });




        //faster way to get the last id and limit
        let limit = 10;
        let last_id = Number.MAX_SAFE_INTEGER;
        let action = 'inactive';
        let temp = 0; // Temporary variable to store the last loaded ID

        function load_posts(limit, last_id) {
            $.ajax({
                url: "fetch_posts.php",
                method: "POST",
                data: {
                    limit: limit,
                    last_id: last_id
                },
                dataType: "json", // ✅ This is required to auto-parse response as JSON
                success: function(response) {
                    if (response.done || !response.html.trim()) {
                        $('#loader').html("No more posts");
                        action = 'active';
                    } else {
                        $('#posts').append(response.html);
                        $('#loader').html("Loading...");
                        temp = response.last_id; // Store the last loaded ID in a temporary variable
                        action = 'inactive';
                    }
                },
                error: function(xhr, status, error) {
                    console.error("❌ Error:", status, error);
                    console.log(xhr.responseText);
                }
            });

        }

        // Initial load
        if (action === 'inactive') {
            action = 'active';
            load_posts(limit, last_id);
        }

        // Infinite scroll with debounce
        let debounceTimer;
        $(window).scroll(function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 300 && action === 'inactive') {
                    last_id = temp; // Use the last loaded ID from the temporary variable
                    action = 'active';
                    load_posts(limit, last_id);
                }
            }, 200);
        });
    </script>
</body>

</html>